<?php
//se evita el acceso directo al documento
defined('_JEXEC') or die('Acceso restringido');

//primero se inicia con informacion sobre el autor y el plugin

/**
*@package Joomla.Plugin
*@subpackage System.pluginMicroservicios
*@since 4.0
*@copyright Copyright (c) 2023 Equipo 2 Andromeda. Todos los derechos reservados.
*@license Lincense
 */

defined('JPATH_BASE') or define('JPATH_BASE', __DIR__ . '/../../../');
defined('JPATH_LIBRARIES') or define('JPATH_LIBRARIES', JPATH_BASE . '/libraries');

require_once JPATH_LIBRARIES . '/src/Plugin/CMSPlugin.php';
use Joomla\CMS\Exception\Exception;
use Joomla\CMS\Factory;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Session\Session;

/** 
 * Todas las funciones deben estar envueltas en una clase 
 *
 * El nombre de la clase debe comenzar con 'PlgSystem' seguido del nombre del complemento. Joomla llama a la clase en función del nombre del complemento, por lo que es muy importante que coincidan 
 */ 

 class PlgSystemPluginMicroservicios extends Joomla\CMS\Plugin\CMSPlugin
 {
    protected $app;
    protected $session;
    protected $user;
    protected $admin;
    protected $autoloadLanguage = true;

    public function __construct(?object &$subject, array $config = []){
        $this->app = Factory::getApplication();
        $this->session = Factory::getSession();
        $this->user = Factory::getUser();
        $this->admin = $this->user->authorise('core.admin');
        parent::__construct($subject, $config);

    }

    public function onContentBeforeDisplay(string $context, &$article, &$params, $page = 0){
        try{
            //registramos el evento de los llamados Ajax
            $this->app->registerEvent('onAjaxPluginMicroservicios', [$this, 'onAjaxPluginMicroservicios']);
            
            //utilizamos el metodo getDocument(), para agregar los documentos de JS y CSS
            $document = Factory::getDocument();
            
            if($this->admin){
                $document->addScript(Uri::root(true).'/plugins/system/pluginMicroservicios/js/admin.js');
                $document->addStyleSheet(Uri::root(true).'/plugins/system/pluginMicroservicios/css/admin.css');
                
                if($context === 'com_content.article'){
                    if(strpos($article->text, '{microserviciosFormAdmin}') === false){
                        return;
                    }
                    
                    $article->text = str_replace('{microserviciosFormAdmin}', $this->displayMicroservicios(), $article->text);
                }
            } else {
                $tokenUser = $this->app->getFormToken();
                $document->addScriptOptions('csrf.token', $tokenUser);
                $document->addScript(Uri::root(true).'/plugins/system/pluginMicroservicios/PlanModular-Front/src/js/main.js');
                $document->addScript(Uri::root(true).'/plugins/system/pluginMicroservicios/PlanModular-Front/bundle.js'); 
                $document->addStyleSheet(Uri::root(true).'/plugins/system/pluginMicroservicios/PlanModular-Front/styles.css');
                
                if($context === 'com_content.article'){
                    if(strpos($article->text, '{microserviciosForm}') === false){
                        return;
                    }
                    $article->text = str_replace('{microserviciosForm}', $this->displayForm(), $article->text);
                }
            }
        } catch(Exception $err){
            echo 'Error: '.$err->getMessage();
        }
    }

    private function displayForm(){
        try{
            $layout = new FileLayout('index', __DIR__.'/plugins/system/pluginMicroservicios/PlanModular-Front');

            return $layout->render();
        } catch(Exception $err){
            echo 'Error: '.$err->getMessage();
        }
    }

    private function displayMicroservicios(){
        try{
            $layout = new FileLayout('admin', __DIR__.'/plugins/system/pluginMicroservicios/tmpl');
            
            return $layout->render();
        } catch(Exception $err){
            echo 'Error: '.$err->getMessage();
        }
    }

    public function onAjaxPluginMicroservicios(): string{
        //verificamos el token del formulario
       Session::checkToken() or die('Token no valido');
       try{
        $input = $this->app->input;
        $method = $input->getMethod();

        require_once __DIR__.'/database/database.php';
        $dataBase = new DataBase;
        
        if($method === 'GET'){
            $servicios = $dataBase->getServicios(); 
            $microserviciosForm = $dataBase->getMicroservicios();
            $sectorEco = $dataBase->getSectorEconomico();

            $result = [
                'servicios' => $servicios, 
                'microservicios' => $microserviciosForm, 'sectorEconomico' => $sectorEco
            ];

            return json_encode($result);
        }

        if($method === 'POST'){
            $accion = $input->get('accion', '', 'cmd');
            $dataResponse = [];

            require_once __DIR__.'/algoritmo/algoritmo.php';
            
            if($this->admin){
                if($accion === 'agregar'){
                    $tipo = $input->get('tipo', '', 'cmd');
                    //para guardar los datos
                    switch ($tipo) {
                        case 'guardar_categoria':
                            $data = [
                                'nombre' => $input->get('agregar_nombre_categoria', '', 'string')
                            ]; 
                            $tabla = 'categoria_servicios';
                            $dataBase->executeGuardar($data, $tabla, $method);
                            break;
                        case 'guardar_servicio':
                            $data = [
                                'nombre' => $input->get('agregar_nombre_servicio', '', 'string'),
                                'estrategia' => $input->get('agregar_estrategia_servicio', '', 'string'),
                                'categoria_id' => $input->get('agregar_categoria_servicio', 0, 'number')
                            ];
            
                            $tabla = 'servicios';
                            $dataBase->executeGuardar($data, $tabla, $method);
                            break;
                        case 'guardar_microservicio':
                            $data = [
                                'nombre' => $input->get('agregar_nombre_microservicio', '', 'string'),
                                'valor_impacto' => $input->get('agregar_valor_impacto_microservicio', 0.0, 'decimal'),
                                'valor_de_costo' => $input->get('agregar_valor_costo_microservicio', 0.0, 'decimal'),
                                'valor_de_ingreso' => $input->get('agregar_valor_ingreso_microservicio', 0.0, 'decimal'),
                                'gasto_publicidad' => $input->get('agregar_gasto_publicidad_microservicio', 0.0, 'decimal'),
                                'servicio_id' => $input->get('agregar_servicio_microservicio', 0, 'number')
                            ];

                            $tabla = 'microservicios';
                            $dataBase->executeGuardar($data, $tabla, $method);
                            break;
                        
                        case 'guardar_sector':
                            $data = [
                                'nombre' => $input->get('agregar_nombre_sector', '', 'string'),
                                'recomendaciones' => $input->get('agregar_recomendaciones_sector', '', 'string'),
                                'microservicio_id' => $input->get('microservicios_user', [], 'array')
                            ];

                            $tabla = 'sector_economico';
                            $dataBase->executeGuardar($data, $tabla, $method);
                            break;

                        default: 
                            $dataResponse['error'] = 'Tipo de accion no válido';
                        }
                    } 
                elseif($accion === 'editar'){
                    //para editar
                    $caso = $input->get('caso', '', 'cmd');
                
                    switch ($caso){
                        case 'editar_categoria':
                            $data = [
                                'id' => $input->get('editar_id_categoria', 0, 'number'),
                                'nombre' => $input->get('editar_categoria_nombre', '', 'string')
                            ];
                            
                            $tabla = 'categoria_servicios';

                            $dataBase->executeEditar($data, $tabla);
                            break;
                        case 'editar_servicio':
                            $data = [
                                'id' => $input->get('editar_id_servicio', 0, 'number'),
                                'nombre' => $input->get('editar_servicio_nombre', '', 'string'),
                                'estrategia' => $input->get('editar_servicio_estrategia', '', 'string'),
                                'categoria_id' => $input->get('editar_categoria_servicio', 0, 'number')
                            ];

                            $tabla = 'servicios';

                            $dataBase->executeEditar($data, $tabla);
                            break;
                            
                        case 'editar_microservicio':
                            $data = [
                                'id' => $input->get('editar_id_microservicio', 0, 'number'),
                                'nombre' => $input->get('editar_nombre_microservicio', '', 'string'),
                                'valor_impacto' => $input->get('editar_valor_impacto_microservicio', 0.0, 'decimal'),
                                'valor_de_costo' => $input->get('editar_valor_costo_microservicio', 0.0, 'decimal'),
                                'valor_de_ingreso' => $input->get('editar_valor_ingreso_microservicio', 0.0, 'decimal'),
                                'gasto_publicidad' => $input->get('editar_gasto_publicidad_microservicio', 0.0, 'decimal'), 
                                'servicio_id' => $input->get('editar_servicio_microservicio', 0, 'number')
                            ];
            
                            $tabla = 'microservicios';
            
                            $dataBase->executeEditar($data, $tabla);
                            break;

                        case 'editar_sector':
                            $data = [
                                'id' => $input->get('editar_id_sector', 0, 'number'),
                                'nombre' => $input->get('editar_nombre_sector', '', 'string'),
                                'recomendaciones' => $input->get('editar_recomendaciones_sector', '', 'string'),
                                'microservicios' => $input->get('microservicios_sector_editar', [], 'array')
                            ];
                
                            $tabla = 'sector_economico';

                            $dataBase->executeEditar($data, $tabla);
                            break;
                        
                        case 'editar_usuario':
                            $data = [
                                'id' => $input->get('editar_id_usuario', 0, 'number'),
                                'estado' => $input->get('editar_estado_usuario', '', 'string')
                            ];

                            $tabla = 'usuario';

                            $dataBase->executeEditar($data, $tabla);
                            break;
                        
                        default:
                        $dataResponse['error'] = 'Tipo de accion no válido';;
                        }
                    }
                    
                elseif($accion === 'eliminar'){
                    $caso = $input->get('caso', '', 'cmd');

                    switch ($caso) {
                        case 'eliminar_categoria':
                            $data = $input->get('eliminar_id_categoria', 0, 'number');
                            
                            $tabla = 'categoria_servicios';

                            $dataBase->executeEliminar($data, $tabla);
                            break;
                        case 'eliminar_servicio':
                            $data = $input->get('eliminar_id_servicio', 0, 'number');

                            $tabla = 'servicios';

                            $dataBase->executeEliminar($data, $tabla);
                            break;
                            
                        case 'eliminar_microservicio':
                            $data = $input->get('eliminar_id_microservicio', 0, 'number');
            
                            $tabla = 'microservicios';
            
                            $dataBase->executeEliminar($data, $tabla);
                            break;

                        case 'eliminar_sector':
                            $data = $input->get('eliminar_id_sector', 0, 'number');
                
                            $tabla = 'sector_economico';

                            $dataBase->executeEliminar($data, $tabla);
                            break;
                        
                        case 'eliminar_usuario':
                            $data = $input->get('eliminar_id_usuario', 0, 'number');

                            $tabla = 'usuario';

                            $dataBase->executeEliminar($data, $tabla);
                            break;
                        
                        default:
                        $dataResponse['error'] = 'Tipo de accion no válido';;
                        }
                    }
                    $dataResponse['success'] = true;
                } 
                else {
                    if($this->user){
                        $tipo = $input->getString('tipo', '', 'cmd');
                        $microserviciosUser = [];
                        switch ($tipo) {
                            case 'userForm':

                                $sectorEconomico = $input->get('sector-comercial', '','string');
                                $expenses = $input->get('expenses', 0, 'number');
                                $roi = $input->get('roi', 0, 'number');
                                $country = $input->get('country', '', 'string');
                                $serviciosMicroservicios = $input->get('microServices', [], 'array');

                                $cadena = $serviciosMicroservicios[0];
                                $sin_scape = stripslashes($cadena);
                                $microservicios = json_decode($sin_scape, true);

                                foreach($microservicios as $microservicio){
                                    foreach($microservicio as $micro){
                                        $microserviciosUser[] = $micro;
                                    }
                                }

                                $algoritmo = new Algoritmo($sectorEconomico, $microservicios, $roi, $expenses);

                                $branding = $algoritmo->matchBranding();
                                $organicGrowth = $algoritmo->matchOrganicGrowth();
                                $totalGrowth = $algoritmo->matchTotalGrowth();
                                $seoLevel = $algoritmo->matchSeoLevel();
                                $projectedEarning = $algoritmo->calculateRoi();
                                $sales = $algoritmo->ventasTrimestre();
                                $plantilla = $algoritmo->matchPlantilla();
                                
                                //guardamos en variables en variables de seccion por si el usuario desea guardarlas seccion 
                                    
                                $dataResponse['branding'] = $branding;
                                $dataResponse['organicGrowth'] = $organicGrowth;
                                $dataResponse['totalGrowth'] = $totalGrowth;
                                $dataResponse['seoLevel'] = $seoLevel;
                                $dataResponse['country'] =[$country]; 
                                $dataResponse['projectedEarnings'] = $projectedEarning;
                                $dataResponse['plantillaRelacion'] = $plantilla;
                                $dataResponse['sales'] = $sales;
                                
                                $this->session->set('dataUser', $dataResponse);
                                $this->session->set('microserviciosUser', $microserviciosUser);
                                $this->session->set('sector', $sectorEconomico);
                                break;

                            case 'guardarDatos':

                                $data = [
                                    'nombre' => $name = $input->get('name', '', 'string'),
                                    'email' => $email = $input->get('email', '', 'string'),
                                    'telefono' => $phone = $input->get('phone', '', 'string'),
                                    'empresa' => $company = $input->get('company', '', 'string')
                                ];
                                    $resultados = $this->session->get('dataUser');
                                    $datosMicroservicios = $this->session->get('microserviciosUser');
                                    $sector = $this->session->get('sector');

                                    $tabla = 'usuario';

                                $data['microservicios'] = json_encode($datosMicroservicios);
                                $data['branding'] = $resultados['branding'];
                                $data['organicGrowth'] = $resultados['organicGrowth'];
                                $data['totalGrowth'] = $resultados['totalGrowth'];
                                $data['levelSEO'] = $resultados['seoLevel'];
                                $data['pais'] = $resultados['country'][0];
                                $data['ganancias'] = $resultados['projectedEarnings'];  
                                $data['ventasTrimestr'] = $resultados['sales'];                              
                                $data['sector'] = $sector;
                            
                                $dataBase->executeGuardar($data, $tabla, $method);

                                $this->session->clear();
                                $dataResponse['success'] = true;
                                break;
                                    
                            default:
                                break;
                            }
                        }
                    }
                    echo json_encode($dataResponse);
                }
            } catch(Exception $e){
                $dataResponse['success'] = false;
                $dataResponse['error'] = $e->getMessage();
                echo json_encode($dataResponse);
            }
        }
};