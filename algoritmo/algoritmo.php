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
    protected $serviciosAnalisis;
    protected $recomendaciones;

    public function __construct($sector, $servicios, $ROI, $expenses)
    {
        $this->servicios = $servicios;
        $this->ROI = $ROI;
        $this->expenses = $expenses;
        $this->recomendaciones = array();
        $this->dataBase = new DataBase;
        $this->microservicios = $this->dataBase->getMicroservicios();
        $this->sectorPlantilla = $this->dataBase->getSectorEconomicoName($sector);
        $this->serviciosAnalisis = $this->dataBase->getServicios();
    }

    public function matchBranding(){
        $result = 0;

        $serviciosDB = [];

        foreach ($this->serviciosAnalisis as $servi){
            if($servi->estrategia === 'branding'){
                $serviciosDB[] = strtolower($servi->nombre);
            }
        }

        foreach ($this->microservicios as $microservicio){
            foreach ($this->servicios as $servicio => $servMicroservicio){
                foreach($servMicroservicio as $microservicioUser){
                    if(in_array(strtolower($servicio), $serviciosDB)){
                        if(strtolower($microservicio->nombre) === strtolower($microservicioUser)){
                            $result += floatval($microservicio->valor_impacto);
                        }
                    }
                    if(in_array('desarrollo de sitio web', $servMicroservicio) && in_array('desarrollo de aplicaciones', $servMicroservicio)){
                        $result -= 6;
                        $this->recomendaciones['branding'] = 'Asegúrese de que el diseño y la funcionalidad de su sitio web
                        y aplicación sean coherentes y complementarios, en lugar de crear experiencias
                        de usuario inconsistentes. O tambien, establezca prioridades en función de las necesidades de su
                        negocio y el comportamiento del usuario, y ajuste el enfoque según sea
                        necesario.';
                    }
                }
            }
        }

        return round($result, 2);
    }

    public function matchOrganicGrowth(){
        $result = 0;

        $serviciosDB = [];

        foreach ($this->serviciosAnalisis as $servi){
            if($servi->estrategia === 'organicGrowth'){
                $serviciosDB[] = strtolower($servi->nombre);
            }
        }

        foreach ($this->microservicios as $microservicio){
            foreach ($this->servicios as $servicio => $servMicroservicio){
                foreach($servMicroservicio as $microservicioUser){
                    if(in_array(strtolower($servicio), $serviciosDB)){
                        if(strtolower($microservicio->nombre) === strtolower($microservicioUser)){
                            $result += floatval($microservicio->valor_impacto);
                        }
                    }
                    if(in_array('marketing en redes sociales', $servMicroservicio) && in_array('marketing en realidad virtual y aumentada', $servMicroservicio)){
                        $result -= 3;
                        $this->recomendaciones['organicGrowth'] = 'Considerar la posibilidad de asignar recursos adicionales a
                        uno u otro en función de los resultados y el retorno de la inversión.
                        Marketing en redes sociales y Marketing en realidad virtual y aumentada. O tambien, si es posible, diseñe campañas de marketing integradas que
                        incorporen elementos de realidad virtual y aumentada en sus esfuerzos de
                        marketing en redes sociales.
                        ';
                    }
                    if(in_array('marketing de afiliacion', $servMicroservicio) && in_array('marketing en rlaciones publicas', $servMicroservicio)){
                        $result -= 3;
                        $this->recomendaciones['organicGrowth2'] = 'Al desarrollar su estrategia de marketing de afiliación, tenga
                        en cuenta cómo puede afectar la percepción pública de su marca y cómo las
                        relaciones públicas pueden influir en su programa de afiliados. O tambien, asegúrese de que sus afiliados representen adecuadamente
                        su marca y trabajen en conjunto con su estrategia de relaciones públicas para
                        mantener una imagen positiva y coherente.';
                    }
                }
            }
        }

        return round($result, 2);
    }

    public function matchTotalGrowth(){
        $result = 0;
        
        $serviciosDB = [];

        foreach ($this->serviciosAnalisis as $servi){
            if($servi->estrategia === 'totalGrowth'){
                $serviciosDB[] = strtolower($servi->nombre);
            }
        }
        
        foreach ($this->microservicios as $microservicio){
            foreach ($this->servicios as $servicio => $servMicroservicio){
                foreach($servMicroservicio as $microservicioUser){
                    if(in_array(strtolower($servicio), $serviciosDB)){
                        if(strtolower($microservicio->nombre) === strtolower($microservicioUser)){
                            $result += floatval($microservicio->valor_impacto);
                        }
                    }
                    if(in_array('marketing de guerrilla', $servMicroservicio) && in_array('publicidad en línea (google ads, facebook ads, etc.)', $servMicroservicio)){
                        $result -= 5;
                        $this->recomendaciones['totalGrowth'] = ': Asegúrese de que su publicidad en línea esté orientada a los
                        mismos objetivos que sus esfuerzos de marketing de guerrilla para evitar la
                        dilución del mensaje. O tambien, ';
                    }
                }
            }
        }

        return round($result, 2);
    }

    public function matchSeoLevel(){
        $result = 0;

        $serviciosDB = [];

        foreach ($this->serviciosAnalisis as $servi){
            if($servi->estrategia === 'levelSEO'){
                $serviciosDB[] = strtolower($servi->nombre);
            }
        }

        foreach ($this->microservicios as $microservicio){
            foreach ($this->servicios as $servicio => $servMicroservicio){
                foreach($servMicroservicio as $microservicioUser){
                    if(in_array(strtolower($servicio), $serviciosDB)){
                        if(strtolower($microservicio->nombre) === strtolower($microservicioUser)){
                            $result += floatval($microservicio->valor_impacto);
                        }
                    }
                    if(in_array('optimizacion de motores de búsqueda (seo)', $servMicroservicio) && in_array('marketing de aplicaciones', $servMicroservicio)){
                        $result -= 4;
                        $this->recomendaciones['levelSEO'] = 'Monitoree el rendimiento de ambas estrategias y ajuste el
                        enfoque según sea necesario para evitar conflictos o duplicaciones de esfuerzos.
                        Optimización de motores de búsqueda (SEO) y Marketing en aplicaciones. O tambien, al desarrollar su estrategia de SEO, tenga en cuenta cómo
                        puede afectar el rendimiento de su marketing en aplicaciones y viceversa.';
                    }
                }
            }
        }

        return round($result, 2);
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

            $aumento = $this->expenses * ($roi / 100);

            $ganancias = $this->expenses + $aumento;

            $result = 0;

            if($ganancias < $this->expenses){
                $result = round($ganancias - $this->expenses, 2);
            } else {
                $result = round($ganancias, 2);
            }

            
            return round($result, 2);
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
            $microserviciosSinSeleccionar = array_unique($microservicioFaltantes);
            $this->recomendaciones['plantilla'] = $microserviciosSinSeleccionar;
        } else {
            $this->recomendaciones['plantilla'] = 'Haz seleccionado todos los microservicios basicos para tu sector.';
        }

        return $this->recomendaciones;

    }

    public function ventasTrimestre(){
        $contador = 0;
        $totalServicios = count($this->servicios);

        foreach ($this->servicios as $servicio => $micro){
            $microserviciosTotales = array_filter($this->microservicios, function($microservicio) use ($servicio){
                return strtolower($microservicio->servicio) === $servicio;
            });

            $todosSeleccionados = true;
            foreach($microserviciosTotales as $microservicioDB){
                if(!in_array(strtolower($microservicioDB->nombre), $micro)){
                    $todosSeleccionados = false;
                    break;
                }
            }

            if($todosSeleccionados){
                $contador++;
            }
        }

        $total = ($contador * 100) / $totalServicios;
        $result = round($total, 2);
        return $result;
    }
}