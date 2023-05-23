<?php
//primero se inicia con informacion sobre el autor y el plugin

/**
*@package Joomla.Plugin
*@subpackage System.plugin_microservicios
*
*@copyright Copyright (c) 2023 Equipo 2 Andromeda. Todos los derechos reservados.
*@license Lincense
 */

//se evita el acceso directo al documento
defined('_JEXEC') or die('Acceso restringido');

use Joomla\CMS\Factory;
use Joomla\CMS\Plugin\CMSPlugin;
// use Joomla\Event\SubscriberInterface;
use Joomla\CMS\Layout\FileLayout;
use Joomla\CMS\Session\Session;
use Joomla\CMS\Language\Text;

/** 
 * Todas las funciones deben estar envueltas en una clase 
 *
 * El nombre de la clase debe comenzar con 'PlgSystem' seguido del nombre del complemento. Joomla llama a la clase en función del nombre del complemento, por lo que es muy importante que coincidan 
 */ 

 class PlgSystemPluginMicroservicios extends CMSPlugin
 {

    protected $app;
    protected $session;
    protected $user;
    protected $admin;

    public function __construct(){
        $this->app = Factory::getApplication();
        $this->session = Factory::getSession();
        $this->user = Factory::getUser();
        $this->admin = $this->user->authorise('core.admin');
    }

    public function onContentBeforeDisplay($context, &$article, &$params, $limitstart = 0){
        //validamos que el usuario no sea admin
        if($this->app->isClient('administrator')){
            return;
         }
 
         $this->app->registerEvent('onAjaxPluginMicroservicios', array($this, 'onAjaxPluginMicroservicios'));
         $document = Factory::getDocument();
 
         if($this->admin){
             $document->addScript('plugins/system/pluginMicroservicios/js/admin.js');
             
             if($context === 'com_content.article'){
                 if(strpos($article->text, '{microserviciosFormAdmin}') === false){
                     return;
                 }
     
                 $article->text = str_replace('{microserviciosFormAdmin}', $this->displayMicroservicios(), $article->text);
             }
         } else {
             $document->addStyleSheet('plugins/system/pluginMicroservicios/PlanModular-Front/styles.css');
             $document->addScript('plugins/system/pluginMicroservicios/PlanModular-Front/bundle.js');
             
             if($context === 'com_content.article'){
                 if(strpos($article->text, '{microserviciosForm}') === false){
                     return;
                 }
                 $article->text = str_replace('{microserviciosForm}', $this->displayForm(), $article->text);
             }
         }
 
         //opcion para renderizar al final de la pagina
         // //creamos una nueva instancia de la clase FileLayout, la cual, renderiza un diseño de plantilla
         // $layout = new FileLayout('formulario', __DIR__.'/tmpl');
         // $form = $layout->render();
 
         // $body = $app->getBody();
         // $body = str_replace('</body>', $form.'</body>', $body);
         // $app->setBody($body);
    }

    private function displayForm(){
        $layout = new FileLayout('index', __DIR__.'/PlanModular-Front');
        return $layout->render();
    }

    private function displayMicroservicios(){
        $layout = new FileLayout('admin', __DIR__.'/tmpl');
        return $layout->render();
    }

    public function onAjaxPluginMicroservicios(){
        //verificamos el token del formulario
        Session::getFormToken() or jexit(Text::_('Token no valido'));

        $input = $this->app->input;
        $accion = $input->get('accion', '', 'cmd');
        $method = $input->getMethod();

        $cosas =$input->get('microservicios_user', array(), 'array');

        require_once __DIR__.'/database/database.php';
        $dataBase = new DataBase;

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
                            'categoria_id' => $input->get('agregar_categoria_servicio', 0, 'number')
                        ];
        
                        $tabla = 'servicios';
                        $dataBase->executeGuardar($data, $tabla, $method);
                            break;
                    case 'guardar_microservicio':
                        $data = [
                            'nombre' => $input->get('agregar_nombre_microservicio', '', 'string'),
                            'valor_impacto' => $input->get('agregar_valor_impacto_microservicio', 0, 'number'),
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
                                'microservicio_id' => $input->get('microservicios_user', array(), 'array')
                            ];
    
                            $tabla = 'sector_economico';
                            $dataBase->executeGuardar($data, $tabla, $method);
                            break;

                    default: 
                        break;
                }
            } 
            if($accion === 'editar'){
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
                            'categoria_id' => $input->get('editar_categoria_servicio', 0, 'number')
                        ];

                        $tabla = 'servicios';

                        $dataBase->executeEditar($data, $tabla);
                        break;
                    
                    case 'editar_microservicio':
                        $data = [
                            'id' => $input->get('editar_id_microservicio', 0, 'number'),
                            'nombre' => $input->get('editar_nombre_microservicio', '', 'string'),
                            'valor_impacto' => $input->get('editar_valor_impacto_microservicio', 0, 'number'),
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
                            'microservicios' => $input->get('microservicios_sector_editar', array(), 'array')
                        ];
        
                        $tabla = 'sector_economico';

                        $dataBase->executeEditar($data, $tabla);
                        break;
                
                    default:
                        break;
                }
            }
        } else {
        if($method === 'POST'){
        $contentType = $_SERVER['CONTENT_TYPE'];
        if ($contentType !== 'application/x-www-form-urlencoded') {
            throw new Exception('Unsupported content type');
        }


        //buscamos los datos del form
        // $sectorEconomico = $input->get('sectorEconomico', '', 'string');
        // $microserviciosUser = $input->get('microserviciosUser', [], 'array');


        // //guardamos los valores en variables de sesión
        // $this->session->set('sectorEconomico', $sectorEconomico);
        // $this->session->set('microserviciosUser', $microserviciosUser);
        
        // $data = [
        //     'select' => $input->get('select', '', 'string'),
        //     'checkbox' => $input->get('checkbox', [], 'array'),
        //     'input' => $input->get('input', '', 'string'),
        // ];

        //require_once __DIR__.'/src/controller.php';
        //$result = PluginMicroserviciosDataBase::execute($data, $method);

        // $microservicio = $this->session->get('microserviciosUser');
        // $response = array('mensaje' => 'Hola, como estas', 'echo' => $input, 'micro' => $microserviciosUser);
        // $result = json_encode($response);
        }
        }

        $result = array('success' => true);     
        return json_encode($result);
        die();
    }
 };