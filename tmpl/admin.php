<?php 
defined('_JEXEC') or die('Acceso restringido');

require_once __DIR__.'/../database/database.php';

use Joomla\CMS\Session\Session;

$token = Session::getFormToken();

$dataBase = new DataBase;

$categoria_servicios = $dataBase->getCategoriaServicios();
$servicios = $dataBase->getServicios();
$microservicios = $dataBase->getMicroservicios();
$sectores = $dataBase->getSectorEconomico();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="plugins/system/pluginMicroservicios/PlanModular-Front/styles.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <title>Servicios y Microservicios</title>
</head>
<body>
    <main class="container">
        <section id="categorias" class="section-container" style="display: none;" >
            <div id="mostrar_categorias">
                <h3>Categoria de servicios</h3>
                <div id="categorias_tabla">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $contador = 1; ?>
                            <?php foreach ($categoria_servicios as $categoria): ?>
                            <tr>
                                <td scope='row' > <?php echo $contador++;?></td>
                                <td><?php echo $categoria->nombre; ?></td>
                                <td>
                                    <button type="button" class="btn btn-outline-light" id="datos_editar_categorias" data-id='<?php echo $categoria->id; ?>' data-nombre='<?php echo $categoria->nombre; ?>' >Edit</button>
                                </td>
                            </tr>      
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div id="agregar_categoria">
                <h4>Agregar Categorias</h4>
                <form id="agregar_categorias_form" >
                    <input type="hidden" name="tipo" value="guardar_categoria" id='tipo_categoria'>
                    <label for="agregar_nombre_categoria" class="col-form-label">Nombre: </label>    
                    <input type="text" class="form-control" name="agregar_nombre_categoria" id="agregar_nombre_categoria" placeholder="nombre de la categoria" />
                    <!-- input oculto para mejorar la seguridad con un Token CSRF-->
                    <input type="hidden" name=<?php echo $token; ?> value="1"/>
                    <button type="submit" class="btn btn-outline-dark">Agregar</button>
                </form>
            </div>

            <div id="editar_categoria">
                <h4>Editar Categorias</h4>
                <form id="editar_categoria_form" >
                    <input type="hidden" name="editar_id_categoria" id="editar_id_categoria" />
                    <input type="hidden" name="caso" value="editar_categoria" />
                    <label for="editar_nombre_categoria" class="col-form-label">Nombre: </label>
                    <input type="text" class="form-control" name="editar_categoria_nombre" id="editar_categoria_nombre" />
                    <!-- input oculto para mejorar la seguridad con un Token CSRF-->
                    <input type="hidden" name=<?php echo $token; ?> value="1"/>
                    <button type="submit" class="btn btn-outline-dark">Actualizar</button>
                </form>
            </div>
        </section>
        <section id="servicios" style="display: none;">
            <div id="mostrar_servicios">
                <h3>Servicios</h3>
                <div id="servicios_tabla">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Estrategia</th>
                                <th>Categoria</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $contador = 1; ?>
                            <?php foreach ($servicios as $ser): ?>
                            <tr>
                                <td scope='row' > <?php echo $contador++;?></td>
                                <td><?php echo $ser->nombre; ?></td>
                                <td><?php echo $ser->estrategia; ?></td>
                                <td><?php echo $ser->categoria; ?></td>
                                <td>
                                    <button type="button" class="btn btn-outline-light" id="datos_editar_servicios" data-id='<?php echo $ser->id; ?>' data-nombre='<?php echo $ser->nombre; ?>' data-estrategia='<?php echo $ser->estrategia; ?>' data-categoria='<?php echo $ser->categoria_id ?>'>Edit</button>
                                </td>
                            </tr>      
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div id="agregar_servicio">
                <h4>Agregar Servicios</h4>
                <form id="agregar_servicio_form" >
                    <input type="hidden" name="tipo" value="guardar_servicio" id='tipo_servicios'>
                    <label for="agregar_nombre_servicio" class="col-form-label">Nombre: </label>    
                    <input type="text" class="form-control" name="agregar_nombre_servicio" id="agregar_nombre_servicio" />
                    <label for="agregar_estrategia_servicio" class="col-form-label">Estrategia: </label>
                    <select name="agregar_estrategia_servicio" class="form-select" id="agregar_estrategia_servicio">
                        <option value=""> -- </option>
                        <option value="branding">Branding</option>
                        <option value="organicGrowth">Organic Growth</option>
                        <option value="totalGrowth">Total Growth</option>
                        <option value="levelSEO"> Level SEO</option>
                    </select>
                    <label for="agregar_categoria_servicio" class="col-form-label" >Categoria: </label>
                    <select name="agregar_categoria_servicio" class="form-select" id="agregar_categoria_servicio">
                        <option value=""> -- </option>
                        <?php foreach($categoria_servicios as $categories): ?>
                        <option value="<?php
                         echo $categories->id; ?>"><?php echo $categories->nombre; ?></option>
                         <?php endforeach ?>
                    </select>
                    <!-- input oculto para mejorar la seguridad con un Token CSRF-->
                    <input type="hidden" name=<?php echo $token; ?> value="1"/>
                    <button type="submit" class="btn btn-outline-dark">Agregar</button>
                </form>
            </div>

            <div id="editar_servicio">
                <h4>Editar Servicio: </h4>
                <form id="editar_servicio_form" >
                    <input type="hidden" name="editar_id_servicio" id="editar_id_servicio" />
                    <input type="hidden" name="caso" value="editar_servicio" />
                    <label for="editar_nombre_servicio" class="col-form-label">Nombre: </label>
                    <input type="text" class="form-control" name="editar_servicio_nombre" id="editar_servicio_nombre" />
                    <label for="editar_servicio_estrategia" class="col-form-label">Estrategia: </label>
                    <select name="editar_servicio_estrategia"  class="form-select" id="editar_servicio_estrategia">
                        <option value=""> -- </option>
                        <option value="branding">Branding</option>
                        <option value="organicGrowth">Organic Growth</option>
                        <option value="totalGrowth">Total Growth</option>
                        <option value="levelSEO"> Level SEO</option>
                    </select>
                    <label for="editar_categoria_servicio" class="col-form-label" >Categoria: </label>
                    <select name="editar_categoria_servicio" class="form-select" id="editar_categoria_servicio">
                        <option value=""> -- </option>
                        <?php foreach($categoria_servicios as $categories): ?>
                        <option value="<?php
                         echo $categories->id; ?>"><?php echo $categories->nombre; ?></option>
                         <?php endforeach ?>
                    </select>
                    <!-- input oculto para mejorar la seguridad con un Token CSRF-->
                    <input type="hidden" name=<?php echo $token; ?> value="1"/>
                    <button type="submit" class="btn btn-outline-dark">Actualizar</button>
                </form>
            </div>
        </section>
        <section id="microservicios" style="display: none;" >
            <div id="mostrar_microservicios">
                <h3>Microservicios</h3>
                <div id="servicios_tabla">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Valor de Impacto</th>
                                <th>Valor de Costo</th>
                                <th>Valor de Ingreso</th>
                                <th>Gasto de Publicidad</th>
                                <th>Servicio</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $contador = 1; ?>
                            <?php foreach ($microservicios as $micro): ?>
                            <tr>
                                <td scope='row' > <?php echo $contador++;?></td>
                                <td><?php echo $micro->nombre; ?></td>
                                <td><?php echo round($micro->valor_impacto, 2); ?> %</td>
                                <td><?php echo $micro->valor_de_costo; ?> EUR</td>
                                <td><?php echo $micro->valor_de_ingreso; ?> EUR</td>
                                <td><?php echo $micro->gasto_publicidad; ?> EUR</td>
                                <td><?php echo $micro->servicio; ?></td>
                                <td>
                                    <button type="button" id="datos_editar_microservicios" class="btn btn-outline-light" data-id='<?php echo $micro->id; ?>' data-nombre='<?php echo $micro->nombre; ?>' data-valor-impacto='<?php echo $micro->valor_impacto; ?>' data-valor-costo='<?php echo $micro->valor_de_costo; ?>' data-valor-ingreso='<?php echo $micro->valor_de_ingreso; ?>' data-gasto-publicidad='<?php echo $micro->gasto_publicidad; ?>' data-servicio='<?php echo $micro->servicio_id; ?>'>Edit</button>
                                </td>	
                            </tr>      
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div id="agregar_microservicio">
                <h4>Agregar Microervicios</h4>
                <form id="agregar_microservicio_form" >
                    <input type="hidden" name="tipo" value="guardar_microservicio" id='tipo_microservicios'>
                    <label for="agregar_nombre_microservicio" class="col-form-label">Nombre: </label>    
                    <input type="text" class="form-control" name="agregar_nombre_microservicio" id="agregar_nombre_microservicio" />
                    <label for="agregar_valor_impacto_microservicio" class="col-form-label">Valor de Impacto: </label>    
                    <input type="number" class="form-control" name="agregar_valor_impacto_microservicio" id="agregar_valor_impacto_microservicio" step="0.01" />
                    <label for="agregar_valor_costo_microservicio" class="col-form-label">Valor de costo: </label>    
                    <input type="number" class="form-control"  name="agregar_valor_costo_microservicio" id="agregar_valor_costo_microservicio" step="0.01"/>
                    <label for="agregar_valor_ingreso_microservicio" class="col-form-label">Valor de Ingresos: </label>    
                    <input type="number" class="form-control" name="agregar_valor_ingreso_microservicio" id="agregar_valor_ingreso_microservicio" step="0.01"/>
                    <label for="agregar_gasto_publicidad_microservicio" class="col-form-label">Gasto de publicidad: </label>    
                    <input type="number" class="form-control" name="agregar_gasto_publicidad_microservicio" id="agregar_gasto_publicidad_microservicio" step="0.01"/>
                    <label for="agregar_servicio_microservicio" class="col-form-label" >Servicios: </label>
                    <select name="agregar_servicio_microservicio" class="form-select" id="agregar_servicio_microservicio">
                        <option value=""> -- </option>
                        <?php foreach($servicios as $serv): ?>
                        <option value="<?php
                         echo $serv->id; ?>"><?php echo $serv->nombre; ?></option>
                         <?php endforeach ?>
                    </select>
                    <!-- input oculto para mejorar la seguridad con un Token CSRF-->
                    <input type="hidden" name=<?php echo $token; ?> value="1"/>
                    <button type="submit" class="btn btn-outline-dark">Agregar</button>
                </form>
            </div>

            <div id="editar_microservicio">
                <h4>Editar Microservicio: </h4>
                <form id="editar_microservicio_form" >
                    <input type="hidden" name="editar_id_microservicio" id="editar_id_microservicio" />
                    <input type="hidden" name="caso" value="editar_microservicio" />
                    <label for="editar_nombre_microservicio" class="col-form-label">Nombre: </label>    
                    <input type="text" class="form-control" name="editar_nombre_microservicio" id="editar_nombre_microservicio" />
                    <label for="editar_valor_impacto_microservicio" class="col-form-label">Valor de Impacto: </label>    
                    <input type="number" class="form-control" name="editar_valor_impacto_microservicio" id="editar_valor_impacto_microservicio" step="0.01"/>
                    <label for="editar_valor_costo_microservicio" class="col-form-label">Valor de costo: </label>    
                    <input type="number" class="form-control" name="editar_valor_costo_microservicio" id="editar_valor_costo_microservicio" step="0.01"/>
                    <label for="editar_valor_ingreso_microservicio" class="col-form-label">Valor de Ingresos: </label>    
                    <input type="number" class="form-control" name="editar_valor_ingreso_microservicio" id="editar_valor_ingreso_microservicio" step="0.01"/>
                    <label for="editar_gasto_publicidad_microservicio" class="col-form-label">Gasto de Publicidad: </label>    
                    <input type="number" name="editar_gasto_publicidad_microservicio" class="form-control" id="editar_gasto_publicidad_microservicio" step="0.01"/>
                    <label for="editar_servicio_microservicio" >Servicios: </label>
                    <select name="editar_servicio_microservicio" class="form-select" id="editar_servicio_microservicio">
                        <option value=""> -- </option>
                        <?php foreach($servicios as $serv): ?>
                        <option value="<?php
                         echo $serv->id; ?>"><?php echo $serv->nombre; ?></option>
                         <?php endforeach ?>
                    </select>
                    <!-- input oculto para mejorar la seguridad con un Token CSRF-->
                    <input type="hidden" name=<?php echo $token; ?> value="1"/>
                    <button type="submit" class="btn btn-outline-dark">Actualizar</button>
                </form>
            </div>
        </section>
        <section id="sector" style="display: none;" >
            <div id="mostrar_sector">
                <h3>Sectores Economicos: </h3>
                <div id="sector_tabla">
                    <table class="table table-dark table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Recomendaciones</th>
                                <th>Microservicios</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $contador = 1; $microservicioId = array(); ?>
                            <?php foreach ($sectores as $sector_id => $sector_data): ?>
                            <tr>
                                <td scope='row' > <?php echo $contador++;?></td>
                                <td><?php echo $sector_data['nombre']; ?></td>
                                <td><?php  echo $sector_data['recomendaciones']; ?></td>
                                <td>
                                    <ul>
                                    <?php foreach ($sector_data['microservicios'] as $microservicio): ?>
                                    <?php $microservicioId[] = $microservicio['id']; ?>
                                        <li><?php echo $microservicio['nombre']  ?></li>
                                        <?php endforeach; ?>
                                    </ul>   
                                </td>
                                <td>
                                    <button type="button" id="datos_editar_sector" class="btn btn-outline-light" data-id='<?php echo $sector_data['id']; ?>' data-nombre='<?php echo $sector_data['nombre']; ?>' data-recomendaciones='<?php echo $sector_data['recomendaciones']; ?>' data-microservicios='<?php  foreach ($sector_data['microservicios'] as $micro): echo $micro['id'];?>,<?php endforeach; ?>'>Edit</button>
                                    <?php endforeach; ?>
                                </td>
                            </tr>      
                        </tbody>
                    </table>
                </div>
            </div>
            
            <div id="agregar_sector">
                <h4>Agregar Sector Economico</h4>
                <form id="agregar_sector_form" >
                    <input type="hidden" name="tipo" value="guardar_sector" id='tipo_sector'>
                    <label for="agregar_nombre_sector" class="col-form-label">Nombre: </label>    
                    <input type="text" class="form-control" name="agregar_nombre_sector" id="agregar_nombre_sector" />
                    <label for="agregar_recomendaciones_sector" class="col-form-label">Recomendaciones: </label>      
                    <textarea name="agregar_recomendaciones_sector" class="form-control" id="agregar_recomendaciones_sector" rows="5" cols="60"></textarea>
                    <label for="agregar_microservicio_sector" class="col-form-label" >Microservicios: </label>
                    <?php foreach ($microservicios as $ms): ?>
                        <div class="form-check">
                            <label for="microservios-<?php echo $ms->id; ?>" class="form-check-label"><?php echo $ms->nombre; ?></label>
                            <input type="checkbox" class="form-check-input" name="microservicios_sector" id="microservios-<?php echo $ms->id?>" value="<?php echo $ms->id ?>">
                        </div>
                        <?php endforeach ?>
                    <!-- input oculto para mejorar la seguridad con un Token CSRF-->
                    <input type="hidden" name=<?php echo $token; ?> value="1"/>
                    <button type="submit" class="btn btn-outline-dark">Agregar</button>
                </form>
            </div>

            <div id="editar_sector">
                <h4>Editar Sector Economico: </h4>
                <form id="editar_sector_form" >
                    <input type="hidden" name="editar_id_sector" id="editar_id_sector" />
                    <input type="hidden" name="caso" value="editar_sector" />
                    <label for="editar_nombre_sector" class="col-form-label">Nombre: </label>    
                    <input type="text" name="editar_nombre_sector" class="form-control" id="editar_nombre_sector" />
                    <label for="editar_recomendaciones_sector" class="col-form-label">Recomendaciones: </label>      
                    <textarea name="editar_recomendaciones_sector" class="form-control" id="editar_recomendaciones_sector" rows="5" cols="60"></textarea>
                    <label for="editar_microservicio_sector" class="col-form-label" >Microservicios: </label>
                    <?php foreach ($microservicios as $ms): ?>
                        <div class="form-check">
                            <label for="microservios-<?php echo $ms->id; ?>-editar" class="form-check-label"><?php echo $ms->nombre; ?></label>
                            <input type="checkbox" class="form-check-input" name="microservicios_sector_editar" id="microservicios-<?php echo $ms->id; ?>-editar" value="<?php echo $ms->id; ?>">
                        </div>
                    <?php endforeach ?>
                    <!-- input oculto para mejorar la seguridad con un Token CSRF-->
                    <input type="hidden" name=<?php echo $token; ?> value="1"/>
                    <button type="submit" class="btn btn-outline-dark">Actualizar</button>
                </form>
            </div>
        </section>

        <section class="btn-group m-5" role="group">
        <button type="button" id="btn_categorias" class="btn btn-outline-dark">Categorias</button>
        <button type="button" id="btn_servicios" class="btn btn-outline-dark">Servicios</button>
        <button type="button" id="btn_microservicios" class="btn btn-outline-dark">Microservicios</button>
        <button type="button" id="btn_sector" class="btn btn-outline-dark">Sectores Economicos</button>
        </section>
        
    </main>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.7/dist/umd/popper.min.js" integrity="sha384-zYPOMqeu1DAVkHiLqWBUTcbYfZ8osu1Nd6Z89ify25QV9guujx43ITvfi12/QExE" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.min.js" integrity="sha384-Y4oOpwW3duJdCWv5ly8SCFYWqFDsfob/3GkgExXKV4idmbt98QcxXYs9UoXAB7BZ" crossorigin="anonymous"></script>
</body>
</html>