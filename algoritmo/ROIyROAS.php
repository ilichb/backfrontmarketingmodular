<?php 
defined('_JEXEC') or die('Acceso restringido');

require_once __DIR__.'/../database/database.php';

class Roi {
    protected $costo;
    protected $ingresos;
    protected $gastoPublicidad;
    
    public function __construct($costo, $ingresos, $gastoPublicidad) {
        $this->costo = $costo;
        $this->ingresos = $ingresos;
        $this->gastoPublicidad = $gastoPublicidad;
    }
    
    public function calculateROI() {
        if ($this->costo === 0) {
            throw new Exception("El costo no puede ser cero al calcular el ROI");
        }
        return (($this->ingresos - $this->costo) / $this->costo) * 100;
    }
}