<?php 
defined('_JEXEC') or die('Acceso restringido');

use Joomla\CMS\Factory;

require_once __DIR__.'/../database/database.php';
require_once __DIR__.'/ROIyROAS.php';

class Algoritmo
{
    protected $servicios;
    protected $ROI;
    protected $expenses;
    protected $dataBase;
    protected $microservicios;
    protected $sectorPlantilla;

    public function __construct($sector, $servicios, $ROI, $expenses)
    {
        $this->servicios = $servicios;
        $this->ROI = $ROI;
        $this->expenses = $expenses;
        $this->dataBase = new DataBase;
        $this->microservicios = $this->dataBase->getMicroservicios();
        $this->sectorPlantilla = $this->dataBase->getSectorEconomicoName($sector);

    }

    public function matchBranding(){
        $result = 0;

        $serviciosDB = array('identidad-corporativa', 'digitales', 'diseño 3D', 'papeleria', 'editorial', 'ilustración', 'fotografia');

        foreach ($this->microservicios as $microservicio){
            foreach ($this->servicios as $servicio => $servMicroservicio){
                foreach($servMicroservicio as $microservicioUser){
                    if(in_array(strtolower($servicio), array_map('strtolower', $serviciosDB))){
                        if(strtolower($microservicio->nombre) === strtolower($microservicioUser)){
                            $result += floatval($microservicio->valor_impacto);
                        }
                    }
                }
            }
        }

        return $result;
    }

    public function matchOrganicGrowth(){
        $result = 0;

        $serviciosDB = array('video', 'socialmedia');

        foreach ($this->microservicios as $microservicio){
            foreach ($this->servicios as $servicio => $servMicroservicio){
                foreach($servMicroservicio as $microservicioUser){
                    if(in_array(strtolower($servicio), array_map('strtolower', $serviciosDB))){
                        if(strtolower($microservicio->nombre) === strtolower($microservicioUser)){
                            $result += floatval($microservicio->valor_impacto);
                        }
                    }
                }
            }
        }

        return $result;
    }

    public function matchTotalGrowth(){
        $result = 0;
        
        $serviciosDB = array('ADS Socialmedia');
        
        foreach ($this->microservicios as $microservicio){
            foreach ($this->servicios as $servicio => $servMicroservicio){
                foreach($servMicroservicio as $microservicioUser){
                    if(in_array(strtolower($servicio), array_map('strtolower', $serviciosDB))){
                        if(strtolower($microservicio->nombre) === strtolower($microservicioUser)){
                            $result += floatval($microservicio->valor_impacto);
                        }
                    }
                }
            }
        }

        return $result;
    }

    public function matchSeoLevel(){
        $result = 0;

        $serviciosDB = array('SEO', 'SEM');

        foreach ($this->microservicios as $microservicio){
            foreach ($this->servicios as $servicio => $servMicroservicio){
                foreach($servMicroservicio as $microservicioUser){
                    if(in_array(strtolower($servicio), array_map('strtolower', $serviciosDB))){
                        if(strtolower($microservicio->nombre) === strtolower($microservicioUser)){
                            $result += floatval($microservicio->valor_impacto);
                        }
                    }
                }
            }
        }

        return $result; 
    }

    public function calculateRoi(){
        $resultCosto = 0;
        $totalRetorno = 0;

        foreach($this->microservicios as $microservicio){
            foreach($this->servicios as $services => $user ){
                foreach($user as $microUser){
                    if(strtolower($microservicio->nombre) === strtolower($microUser)){

                        $costo = floatval($microservicio->valor_de_costo);$ingresos = floatval($microservicio->valor_de_ingreso); $publicidad = floatval($microservicio->gasto_publicidad);
                         
                        $classRoi = new Roi($costo, $ingresos, $publicidad);

                         $totalRetorno += $classRoi->calculateROI();
                         
                         $resultCosto += floatval($microservicio->valor_de_costo);
                    }
                }
            }
        }

        if($resultCosto === 0){
            throw new Exception("Error Processing Request");
        } else {
            $roi = ($totalRetorno - $resultCosto) / $resultCosto;

            $result = number_format($roi, 2);
            return $result;
        }
    }

    public function matchPlantilla(){

        $microservicioFaltantes = [];

        foreach($this->servicios as $serv => $microUser){
            foreach($this->sectorPlantilla as $microservicio){
                if(!in_array($microservicio->microservicios_nombre, $microUser)){
                    $microservicioFaltantes[] = $microservicio->microservicios_nombre;
                }
            }
        }

        if(!empty($microservicioFaltantes)){
            return $microservicioFaltantes;
        } else {
            return 'Haz seleccionado todos los microservicios basicos para tu sector.';
        }
    }
}