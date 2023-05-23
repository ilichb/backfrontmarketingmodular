<?php

defined('_JEXEC') or die;

use Joomla\CMS\Factory;

class DataBase
{
    protected $db;
    protected $session;

    public function __construct(){
        //Se inicializa la variable de la base de datos
        $this->db = Factory::getDbo();
        //$this->db = Factory::getDbo();
        $this->session = Factory::getSession();
    }

    public function executeGuardar($data, $tabla, $method){

        //verificamos si el formulario envia un metodo post
        if($method !== 'POST'){
            throw new Exception('Method not allowed');
        }

        $this->guardar($data, $tabla);
    }

    public function executeEditar($data, $tabla){
        $this->editar($data, $tabla);
    }

    protected function guardar($data, $tablaDb){
        $query = $this->db->getQuery(true);

        switch($tablaDb){
            case 'categoria_servicios':
                //columnas de la base de datos
                $columns = ['nombre'];
                
                //aseguramos o protegemos los valores
                $values = [$this->db->quote($data['nombre'])];
                
                //insertamos los valores en la base de datos
                $query->insert($this->db->quoteName('categoria_servicios'))
                ->columns($this->db->quoteName($columns))
                ->values(implode(',', $values));
                break;

            case 'servicios':
                $columns = ['nombre', 'categoria_id'];
    
                $values = [$this->db->quote($data['nombre']), $this->db->quote($data['categoria_id'])];

                $query->insert($this->db->quoteName('servicios'))
                ->columns($this->db->quoteName($columns))
                ->values(implode(',', $values));
                break;    
            
            case 'microservicios':
                $columns = ['nombre', 'valor_impacto', 'valor_de_costo', 'valor_de_ingreso', 'gasto_publicidad', 'servicio_id'];

                $values = [$this->db->quote($data['nombre']),
                $this->db->quote($data['valor_impacto']),
                $this->db->quote($data['valor_de_costo']), $this->db->quote($data['valor_de_ingreso']), $this->db->quote($data['gasto_publicidad']),
                $this->db->quote($data['servicio_id'])];

                $query->insert($this->db->quoteName('microservicios'))
                ->columns($this->db->quoteName($columns))
                ->values(implode(',', $values));
                break;
            
            case 'sector_economico':
                $columns = ['nombre', 'recomendaciones'];

                $values = [$this->db->quote($data['nombre']), $this->db->quote($data['recomendaciones'])];

                $query->insert($this->db->quoteName('sector_economico'))
                ->columns($this->db->quoteName($columns))
                ->values(implode(',', $values));
                break;

            default:
                break;
            }
        
        $this->db->setQuery($query);
        $this->db->execute();

        if($tablaDb === 'sector_economico'){
            $sectorId = $this->db->insertId();

            $this->guardarRelacion(intval($sectorId), $data['microservicio_id']);
        }
        $query->clear();
    }

    protected function guardarRelacion($sectorId, $microservicios){

        //relacionamos con los microservicios
         $columns = ['sector_id', 'microservicio_id'];

         $microserviciosRecorrer = explode(',', $microservicios[0]);

         foreach ($microserviciosRecorrer as $microservicio => $Id) {

             $query = $this->db->getQuery(true);
             $values = array($this->db->quote($sectorId), $this->db->quote($Id));

             $query->insert($this->db->quoteName('sector_microservicios'))
             ->columns($this->db->quoteName($columns))
             ->values(implode(',', $values));

            $this->db->setQuery($query);
            $this->db->execute();
         }
        $query->clear();
    }

    protected function editar($data, $tablaDb){
        $query = $this->db->getQuery(true);

        switch($tablaDb){
            case 'categoria_servicios':

                $datos = array(
                    $this->db->quoteName('nombre').'='.$this->db->quote($data['nombre'])
                );

                $condiciones = array(
                    $this->db->quoteName('id').'='.$this->db->quote($data['id'])
                );

                $query->update($this->db->quoteName('categoria_servicios'))
                ->set($datos)
                ->where($condiciones);
                break;

            case 'servicios':

                $datos = array(
                    $this->db->quoteName('nombre').'='.$this->db->quote($data['nombre']),
                    $this->db->quoteName('categoria_id').'='.$this->db->quote($data['categoria_id'])
                );

                $condiciones = array(
                    $this->db->quoteName('id').'='.$this->db->quote($data['id'])
                );

                $query->update($this->db->quoteName('servicios'))
                ->set($datos)
                ->where($condiciones);
                break;
            
            case 'microservicios':

                $datos = array(
                    $this->db->quoteName('nombre').'='.$this->db->quote($data['nombre']),
                    $this->db->quoteName('valor_impacto').'='.$this->db->quote($data['valor_impacto']),
                    $this->db->quoteName('valor_de_costo').'='.$this->db->quote($data['valor_de_costo']),
                    $this->db->quoteName('valor_de_ingreso').'='.$this->db->quote($data['valor_de_ingreso']),
                    $this->db->quoteName('gasto_publicidad').'='.$this->db->quote($data['gasto_publicidad']),
                    $this->db->quoteName('servicio_id').'='.$this->db->quote($data['servicio_id'])
                );
    
                $condiciones = array(
                    $this->db->quoteName('id').'='.$this->db->quote($data['id'])
                );
    
                $query->update($this->db->quoteName('microservicios'))
                ->set($datos)
                ->where($condiciones);
                break;
            
            case 'sector_economico':

                $datos = array(
                    $this->db->quoteName('nombre').'='.$this->db->quote($data['nombre']),
                    $this->db->quoteName('recomendaciones').'='.$this->db->quote($data['recomendaciones'])
                );
        
                $condiciones = array(
                    $this->db->quoteName('id').'='.$this->db->quote($data['id'])
                );
        
                $query->update($this->db->quoteName('sector_economico'))
                ->set($datos)
                ->where($condiciones);
                
                $this->editarRelacion($data['id'], $data['microservicios']);
                break;
            
            default:
                break;
        }

        $this->db->setQuery($query)->execute();
        $query->clear();

    }

    protected function editarRelacion($sectorId, $microservicios){
        $query = $this->db->getQuery(true);

        //eliminamos la vieja relacion
        $query->delete($this->db->quoteName('sector_microservicios'))
        ->where($this->db->quoteName('sector_id').'='.$sectorId);

        $this->db->setQuery($query);
        $this->db->execute();
        $query->clear();


        //si se borran todos los microservicios, comprobamos si se va a agregar un microservicio
        //relacionamos con los microservicios editados
        $columns = ['sector_id', 'microservicio_id'];

        $microserviciosRecorrer = explode(',', $microservicios[0]);

        foreach ($microserviciosRecorrer as $microservicio => $Id) {
            //otra forma de hacerlo
            if($Id === '' | $Id === 0){
                break;
            }

            $values = array($this->db->quote($sectorId), $this->db->quote($Id));

            $query->insert($this->db->quoteName('sector_microservicios'))
            ->columns($this->db->quoteName($columns))
            ->values(implode(',', $values));
        
        $this->db->setQuery($query);
        $this->db->execute();
        $query->clear();     
        }
    }

    public function getCategoriaServicios(){
        $query = $this->db->getQuery(true);

        $query->select('*')
        ->from($this->db->quoteName('categoria_servicios'));
        
        $this->db->setQuery($query);

        $result = $this->db->loadObjectList() ?? [];

        $query->clear();

        return $result;
    }

    public function getServicios(){
        $query = $this->db->getQuery(true);

        $query->select(array($this->db->quoteName('s.id'), $this->db->quoteName('s.nombre'), $this->db->quoteName('c.nombre', 'categoria'), $this->db->quoteName('s.categoria_id')))
        ->from($this->db->quoteName('servicios', 's'))
        ->join('LEFT', $this->db->quoteName('categoria_servicios', 'c').'ON('.$this->db->quoteName('s.categoria_id').'='.$this->db->quoteName('c.id').')');
        
        $this->db->setQuery($query);

        $result = $this->db->loadObjectList() ?? [];

        $query->clear();

        return $result;
    }

    public function getMicroservicios(){
        $query = $this->db->getQuery(true);

        $query->select(array($this->db->quoteName('m.id'), $this->db->quoteName('m.nombre'), $this->db->quoteName('m.valor_impacto'), $this->db->quoteName('m.valor_de_costo'), $this->db->quoteName('m.valor_de_ingreso'), $this->db->quoteName('m.gasto_publicidad'),$this->db->quoteName('s.nombre', 'servicio'), $this->db->quoteName('m.servicio_id')))
        ->from($this->db->quoteName('microservicios', 'm'))
        ->join('LEFT', $this->db->quoteName('servicios', 's').'ON('.$this->db->quoteName('m.servicio_id').'='.$this->db->quoteName('s.id').')');
        
        $this->db->setQuery($query);

        $result = $this->db->loadObjectList() ?? [];

        $query->clear();

        return $result;
    }

    public function getSectorEconomico(){
        $query = $this->db->getQuery();

        $query->select(array($this->db->quoteName('se.id', 'sector_id'), $this->db->quoteName('se.nombre', 'sector_nombre'), $this->db->quoteName('se.recomendaciones','sector_recomendaciones'), $this->db->quoteName('m.id','microservicios_id'), $this->db->quoteName('m.nombre','microservicios_nombre'), $this->db->quoteName('m.valor_impacto', 'valor_impacto')))
        ->from($this->db->quoteName('sector_economico', 'se'))
        ->join('LEFT', $this->db->quoteName('sector_microservicios', 'sm').'ON('.$this->db->quoteName('se.id').'='.$this->db->quoteName('sm.sector_id').')')
        ->join('LEFT', $this->db->quoteName('microservicios', 'm').'ON('. $this->db->quoteName('m.id').'='.$this->db->quoteName('sm.microservicio_id').')')
        ->order($this->db->quoteName('m.valor_impacto'));

        $this->db->setQuery($query);

        $sectores = $this->db->loadObjectList() ?? [];

        $query->clear();

        $result = array();

        foreach ($sectores as $row) {
            if(!isset($result[$row->sector_id])){
                $result[$row->sector_id] = [
                    'id' => $row->sector_id,
                    'nombre' => $row->sector_nombre,
                    'recomendaciones' => $row->sector_recomendaciones,
                    'microservicios' => []
                ];
            }

            $result[$row->sector_id]['microservicios'][] = [
                'id' => $row->microservicios_id,
                'nombre' => $row->microservicios_nombre
            ];
        }

        return $result;

    }
}