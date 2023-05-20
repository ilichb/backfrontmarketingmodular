<?php 
defined('_JEXEC') or die('Acceso restringido');

require_once __DIR__.'/../database/database.php';

$dataBase = new DataBase;

$categoria_servicios = $dataBase->getCategoriaServicios();
$servicios = $dataBase->getServicios();
$microservicios = $dataBase->getMicroservicios();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios y Microservicios</title>
</head>
<body>
    <main>
        <section id="categorias" style="display: none;" >
            <div id="mostrar_categorias">
                <h3>Categoria de servicios</h3>
                <div id="categorias_tabla">
                    <table>
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
                                    <button type="button" id="datos_editar_categorias" data-id='<?php echo $categoria->id; ?>' data-nombre='<?php echo $categoria->nombre; ?>' >Edit</button>
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
                    <label for="agregar_nombre_categoria">Nombre: </label>    
                    <input type="text" name="agregar_nombre_categoria" id="agregar_nombre_categoria" placeholder="nombre de la categoria" />
                    <!-- input oculto para mejorar la seguridad con un Token CSRF-->
                    <input type="hidden" name=<?php echo $token; ?> value="1"/>
                    <button type="submit">Agregar</button>
                </form>
            </div>

            <div id="editar_categoria">
                <h4>Editar Categorias</h4>
                <form id="editar_categoria_form" >
                    <input type="hidden" name="editar_id_categoria" id="editar_id_categoria" />
                    <input type="hidden" name="caso" value="editar_categoria" />
                    <label for="editar_nombre_categoria">Nombre: </label>
                    <input type="text" name="editar_categoria_nombre" id="editar_categoria_nombre" />
                    <!-- input oculto para mejorar la seguridad con un Token CSRF-->
                    <input type="hidden" name=<?php echo $token; ?> value="1"/>
                    <button type="submit">Actualizar</button>
                </form>
            </div>
        </section>
        <section id="servicios" style="display: none;">
            <div id="mostrar_servicios">
                <h3>Servicios</h3>
                <div id="servicios_tabla">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
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
                                <td><?php echo $ser->categoria; ?></td>
                                <td>
                                    <button type="button" id="datos_editar_servicios" data-id='<?php echo $ser->id; ?>' data-nombre='<?php echo $ser->nombre; ?>' data-categoria='<?php echo $ser->categoria_id ?>'>Edit</button>
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
                    <label for="agregar_nombre_servicio">Nombre: </label>    
                    <input type="text" name="agregar_nombre_servicio" id="agregar_nombre_servicio" />
                    <label for="agregar_categoria_servicio" >Categoria: </label>
                    <select name="agregar_categoria_servicio" id="agregar_categoria_servicio">
                        <option value=""> -- </option>
                        <?php foreach($categoria_servicios as $categories): ?>
                        <option value="<?php
                         echo $categories->id; ?>"><?php echo $categories->nombre; ?></option>
                         <?php endforeach ?>
                    </select>

                    <button type="submit">Agregar</button>
                </form>
            </div>

            <div id="editar_servicio">
                <h4>Editar Servicio: </h4>
                <form id="editar_servicio_form" >
                    <input type="hidden" name="editar_id_servicio" id="editar_id_servicio" />
                    <input type="hidden" name="caso" value="editar_servicio" />
                    <label for="editar_nombre_servicio">Nombre: </label>
                    <input type="text" name="editar_servicio_nombre" id="editar_servicio_nombre" />
                    <label for="editar_categoria_servicio" >Categoria: </label>
                    <select name="editar_categoria_servicio" id="editar_categoria_servicio">
                        <option value=""> -- </option>
                        <?php foreach($categoria_servicios as $categories): ?>
                        <option value="<?php
                         echo $categories->id; ?>"><?php echo $categories->nombre; ?></option>
                         <?php endforeach ?>
                    </select>
                    <button type="submit">Actualizar</button>
                </form>
            </div>
        </section>
        <section id="microservicios" style="display: none;" >
            <div id="mostrar_microservicios">
                <h3>Microservicios</h3>
                <div id="servicios_tabla">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Nombre</th>
                                <th>Valor de Impacto</th>
                                <th>Valor de Costo</th>
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
                                <td><?php echo $micro->valor_impacto; ?></td>
                                <td><?php echo $micro->valor_de_costo; ?></td>
                                <td><?php echo $micro->servicio; ?></td>
                                <td>
                                    <button type="button" id="datos_editar_microservicios" data-id='<?php echo $micro->id; ?>' data-nombre='<?php echo $micro->nombre; ?>' data-valor-impacto='<?php echo $micro->valor_impacto; ?>' data-valor-costo='<?php echo $micro->valor_de_costo; ?>' data-servicio='<?php echo $micro->servicio_id; ?>'>Edit</button>
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
                    <label for="agregar_nombre_microservicio">Nombre: </label>    
                    <input type="text" name="agregar_nombre_microservicio" id="agregar_nombre_microservicio" />
                    <label for="agregar_valor_impacto_microservicio">Valor de Impacto: </label>    
                    <input type="number" name="agregar_valor_impacto_microservicio" id="agregar_valor_impacto_microservicio" />
                    <label for="agregar_valor_costo_microservicio">Valor de costo: </label>    
                    <input type="number" name="agregar_valor_costo_microservicio" id="agregar_valor_costo_microservicio"/>
                    <label for="agregar_servicio_microservicio" >Servicios: </label>
                    <select name="agregar_servicio_microservicio" id="agregar_servicio_microservicio">
                        <option value=""> -- </option>
                        <?php foreach($servicios as $serv): ?>
                        <option value="<?php
                         echo $serv->id; ?>"><?php echo $serv->nombre; ?></option>
                         <?php endforeach ?>
                    </select>

                    <button type="submit">Agregar</button>
                </form>
            </div>

            <div id="editar_microservicio">
                <h4>Editar Microservicio: </h4>
                <form id="editar_microservicio_form" >
                    <input type="hidden" name="editar_id_microservicio" id="editar_id_microservicio" />
                    <input type="hidden" name="caso" value="editar_microservicio" />
                    <label for="editar_nombre_microservicio">Nombre: </label>    
                    <input type="text" name="editar_nombre_microservicio" id="editar_nombre_microservicio" />
                    <label for="editar_valor_impacto_microservicio">Valor de Impacto: </label>    
                    <input type="number" name="editar_valor_impacto_microservicio" id="editar_valor_impacto_microservicio" />
                    <label for="editar_valor_costo_microservicio">Valor de costo: </label>    
                    <input type="number" name="editar_valor_costo_microservicio" id="editar_valor_costo_microservicio"/>
                    <label for="editar_servicio_microservicio" >Servicios: </label>
                    <select name="editar_servicio_microservicio" id="editar_servicio_microservicio">
                        <option value=""> -- </option>
                        <?php foreach($servicios as $serv): ?>
                        <option value="<?php
                         echo $serv->id; ?>"><?php echo $serv->nombre; ?></option>
                         <?php endforeach ?>
                    </select>
                    <button type="submit">Actualizar</button>
                </form>
            </div>
        </section>
        <section id="sector" style="display: none;" >
            <div>
                <h3>Sectores Economicos</h3>
            </div>
        </section>

        <section>
        <button type="button" id="btn_categorias">Categorias</button>
        <button type="button" id="btn_servicios">Servicios</button>
        <button type="button" id="btn_microservicios">Microservicios</button>
        <button type="button" id="btn_sector">Sectores Economicos</button>
        </section>
        
    </main>
    
</body>
</html>