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
                $columns = ['nombre', 'valor_impacto', 'valor_de_costo','servicio_id'];

                $values = [$this->db->quote($data['nombre']),
                $this->db->quote($data['valor_impacto']),
                $this->db->quote($data['valor_de_costo']),
                $this->db->quote($data['servicio_id'])];

                $query->insert($this->db->quoteName('microservicios'))
                ->columns($this->db->quoteName($columns))
                ->values(implode(',', $values));
                break;

            default:
                break;
            }
        
        $this->db->setQuery($query);
        $this->db->execute();
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
                    $this->db->quoteName('servicio_id').'='.$this->db->quote($data['servicio_id'])
                );
    
                $condiciones = array(
                    $this->db->quoteName('id').'='.$this->db->quote($data['id'])
                );
    
                $query->update($this->db->quoteName('microservicios'))
                ->set($datos)
                ->where($condiciones);
                break;
            
            default:
                break;
        }

        $this->db->setQuery($query)->execute();

    }

    public function getCategoriaServicios(){
        $query = $this->db->getQuery(true);

        $query->select('*')
        ->from($this->db->quoteName('categoria_servicios'));
        
        $this->db->setQuery($query);

        $result = $this->db->loadObjectList() ?? [];

        return $result;
    }

    public function getServicios(){
        $query = $this->db->getQuery(true);

        $query->select(array($this->db->quoteName('s.id'), $this->db->quoteName('s.nombre'), $this->db->quoteName('c.nombre', 'categoria'), $this->db->quoteName('s.categoria_id')))
        ->from($this->db->quoteName('servicios', 's'))
        ->join('LEFT', $this->db->quoteName('categoria_servicios', 'c').'ON('.$this->db->quoteName('s.categoria_id').'='.$this->db->quoteName('c.id').')');
        
        $this->db->setQuery($query);

        $result = $this->db->loadObjectList() ?? [];

        return $result;
    }

    public function getMicroservicios(){
        $query = $this->db->getQuery(true);

        $query->select(array($this->db->quoteName('m.id'), $this->db->quoteName('m.nombre'), $this->db->quoteName('m.valor_impacto'), $this->db->quoteName('m.valor_de_costo'), $this->db->quoteName('s.nombre', 'servicio'), $this->db->quoteName('m.servicio_id')))
        ->from($this->db->quoteName('microservicios', 'm'))
        ->join('LEFT', $this->db->quoteName('servicios', 's').'ON('.$this->db->quoteName('m.servicio_id').'='.$this->db->quoteName('s.id').')');
        
        $this->db->setQuery($query);

        $result = $this->db->loadObjectList() ?? [];

        return $result;
    }

    public function getSectorEconomico(){
        $query = $this->db->getQuery();

        $id = $this->session->get('sectorEconomicoId');

        $query->select('*')
        ->from($this->db->quoteName('sector_economico'))
        ->where($this->db->quoteName('id').'='.$this->db->quoteName($id));

        $this->db->setQuery($query);

        $result = $this->db->loadObject();
        //loadObjectList

        return $result;

    }
}