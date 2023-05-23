<?php 
defined('_JEXEC') or die('Acceso restringido');

use Joomla\CMS\Factory;

class Algoritmo
{
    protected $sector;
    protected $servicios;
    protected $ROI;
    protected $marketingUltimoSemestre;

    function __construct($sector, $servicios, $ROI, $marketingUltimoSemestre)
    {
        $this->$sector = $sector;
        $this->$servicios = $servicios;
        $this->$ROI = $ROI;
        $this->$marketingUltimoSemestre = $marketingUltimoSemestre;
    }

    function matchServices(){
    }
}