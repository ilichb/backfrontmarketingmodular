document.addEventListener('DOMContentLoaded', () => {
    
    //funcionalidad de los botones
    document.getElementById('btn_categorias').addEventListener('click', () => {
        let categorias = document.getElementById('categorias');
        if(categorias.style.display === 'none'){
            categorias.style.display = 'block';
        } else {
            categorias.style.display = 'none'
        }
    });
    document.getElementById('btn_servicios').addEventListener('click', () => {
        let servicios = document.getElementById('servicios');
        if(servicios.style.display === 'none'){
            servicios.style.display = 'block';
        } else {
            servicios.style.display = 'none'
        }
    });
    document.getElementById('btn_microservicios').addEventListener('click', () => {
        let microservicios = document.getElementById('microservicios');
        if(microservicios.style.display === 'none'){
            microservicios.style.display = 'block';
        } else {
            microservicios.style.display = 'none'
        }
    });
    document.getElementById('btn_sector').addEventListener('click', () => {
        let sector = document.getElementById('sector');
        if(sector.style.display === 'none'){
            sector.style.display = 'block';
        } else {
            sector.style.display = 'none'
        }
    });

    //categorias agregar
    const formCategoriasAgregar = document.getElementById('agregar_categorias_form')
    formCategoriasAgregar.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        formData.append('accion', 'agregar');

        const response = await fetch('index.php?option=com_ajax&plugin=pluginMicroservicios&format=json', {
            method: 'POST',
            body: formData
        });

        const jsonResponse = await response.json();
        if(jsonResponse.success){
            alert('Datos guardados');
            location.reload();
        } else {
            alert('error');
        }

    });

    //editar categorias
    //obteniendo datos de botones en un array
    const editarCategoriasBotones = document.querySelectorAll('#datos_editar_categorias');
    editarCategoriasBotones.forEach(editarBoton => {
        editarBoton.addEventListener('click', (e) => {
            //datos de cada uno de los botones
            const id = e.target.getAttribute('data-id');
            const nombre = e.target.getAttribute('data-nombre');

            //llenamos el formulario de editar
            document.getElementById('editar_id_categoria').value = id;
            document.getElementById('editar_categoria_nombre').value = nombre;
        });
    });

    const formCategoriasEditar = document.getElementById('editar_categoria_form')
    formCategoriasEditar.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        formData.append('accion', 'editar');

        const response = await fetch('index.php?option=com_ajax&plugin=pluginMicroservicios&format=json', {
            method:'POST', //utilizado por compatibilidad con FormData
            body: formData
        })
        
        const jsonResponse = await response.json();

        if(jsonResponse.success){
            alert('Datos Editados Correctamente');
            location.reload();
        } else {
            alert('error');
        }
    });

    //servicios agregar
    const formServiciosAgregar = document.getElementById('agregar_servicio_form')
    formServiciosAgregar.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        formData.append('accion', 'agregar');

        const response = await fetch('index.php?option=com_ajax&plugin=pluginMicroservicios&format=json', {
            method: 'POST',
            body: formData
        });

        const jsonResponse = await response.json();
        if(jsonResponse.success){
            console.log(jsonResponse)
            alert('Datos guardados');
            location.reload();
        } else {
            alert('error');
        }

    });

    //editar servicios
    //obteniendo datos de botones en un array
    const editarServiciosBotones = document.querySelectorAll('#datos_editar_servicios');
    editarServiciosBotones.forEach(editarBoton => {
        editarBoton.addEventListener('click', (e) => {
            //datos de cada uno de los botones
            const id = e.target.getAttribute('data-id');
            const nombre = e.target.getAttribute('data-nombre');
            const categoria = e.target.getAttribute('data-categoria');

            //llenamos el formulario de editar
            document.getElementById('editar_id_servicio').value = id;
            document.getElementById('editar_servicio_nombre').value = nombre;
            document.getElementById('editar_categoria_servicio').value = categoria
        });
    });

    const formServiciosEditar = document.getElementById('editar_servicio_form')
    formServiciosEditar.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        formData.append('accion', 'editar');

        const response = await fetch('index.php?option=com_ajax&plugin=pluginMicroservicios&format=json', {
            method:'POST', //utilizado por compatibilidad con FormData
            body: formData
        })
        
        const jsonResponse = await response.json();

        if(jsonResponse.success){
            alert('Datos Editados Correctamente');
            location.reload();
        } else {
            alert('error');
        }
    });

    //microservicios agregar
    const formMicroserviciosAgregar = document.getElementById('agregar_microservicio_form')
    formMicroserviciosAgregar.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        formData.append('accion', 'agregar');

        const response = await fetch('index.php?option=com_ajax&plugin=pluginMicroservicios&format=json', {
            method: 'POST',
            body: formData
        });

        const jsonResponse = await response.json();
        if(jsonResponse.success){
            console.log(jsonResponse)
            alert('Datos guardados');
            location.reload();
        } else {
            console.log(jsonResponse)
            alert('error');
        }

    });

    //editar microservicios
    //obteniendo datos de botones en un array
    const editarMicroserviciosBotones = document.querySelectorAll('#datos_editar_microservicios');
    editarMicroserviciosBotones.forEach(editarBoton => {
        editarBoton.addEventListener('click', (e) => {
            //datos de cada uno de los botones
            const id = e.target.getAttribute('data-id');
            const nombre = e.target.getAttribute('data-nombre');
            const valorImpacto = e.target.getAttribute('data-valor-impacto');
            const valorCosto = e.target.getAttribute('data-valor-costo');
            const valorIngreso = e.target.getAttribute('data-valor-ingreso');
            const gastoPublicidad = e.target.getAttribute('data-gasto-publicidad');
            const servicio = e.target.getAttribute('data-servicio');

            //llenamos el formulario de editar
            document.getElementById('editar_id_microservicio').value = id;
            document.getElementById('editar_nombre_microservicio').value = nombre;
            document.getElementById('editar_valor_impacto_microservicio').value = valorImpacto;
            document.getElementById('editar_valor_costo_microservicio').value = valorCosto;
            document.getElementById('editar_valor_ingreso_microservicio').value = valorIngreso;
            document.getElementById('editar_gasto_publicidad_microservicio').value = gastoPublicidad;
            document.getElementById('editar_servicio_microservicio').value = servicio;
        });
    });

    const formMicroserviciosEditar = document.getElementById('editar_microservicio_form')
    formMicroserviciosEditar.addEventListener('submit', async (e) => {
        e.preventDefault();

        const formData = new FormData(e.target);
        formData.append('accion', 'editar');

        const response = await fetch('index.php?option=com_ajax&plugin=pluginMicroservicios&format=json', {
            method:'POST', //utilizado por compatibilidad con FormData
            body: formData
        })
        
        const jsonResponse = await response.json();

        if(jsonResponse.success){
            alert('Datos Editados Correctamente');
            location.reload();
        } else {
            alert('error');
        }
    });

    //sectores agregar
    const formSectoresAgregar = document.getElementById('agregar_sector_form')
    formSectoresAgregar.addEventListener('submit', async (e) => {
        e.preventDefault();

        let microserviciosUser = Array.from(document.querySelectorAll('input[name="microservicios_sector"]:checked')).map((c) => {
            return c.value;
       });

       microserviciosUser = microserviciosUser.map(n => parseInt(n));

        const formData = new FormData(e.target);
        formData.append('accion', 'agregar');
        formData.append('microservicios_user', microserviciosUser);

        const response = await fetch('index.php?option=com_ajax&plugin=pluginMicroservicios&format=json', {
            method: 'POST',
            body: formData
        });

        const jsonResponse = await response.json();
        if(jsonResponse.success){
            alert('Datos guardados');
            location.reload();
        } else {
            alert('error');
            location.reload();
        }

    });

    //editar sectores
    //obteniendo datos de botones en un array
    const editarSectoresBotones = document.querySelectorAll('#datos_editar_sector');
    editarSectoresBotones.forEach(editarBoton => {
        editarBoton.addEventListener('click', (e) => {
            //datos de cada uno de los botones
            const id = e.target.getAttribute('data-id');
            const nombre = e.target.getAttribute('data-nombre');
            const recomendaciones = e.target.getAttribute('data-recomendaciones');
            const microservicios = e.target.getAttribute('data-microservicios');

            //llenamos el formulario de editar
            document.getElementById('editar_id_sector').value = id;
            document.getElementById('editar_nombre_sector').value = nombre;
            document.getElementById('editar_recomendaciones_sector').value = recomendaciones;
            checkboxEditar = document.getElementsByName('microservicios_sector_editar');

            let microserviciosId = microservicios.split(',').map((id) => parseInt(id));
            microserviciosId.pop();
            console.log(microserviciosId);

            for(let checkbox of checkboxEditar){
                for(let ms of microserviciosId){
                    if(ms === parseInt(checkbox.value)){
                        checkbox.checked = true;
                    }
                }
            }
        });
    });

    const formSectoresEditar = document.getElementById('editar_sector_form')
    formSectoresEditar.addEventListener('submit', async (e) => {
        e.preventDefault();

        let microserviciosUserEditar = Array.from(document.querySelectorAll('input[name="microservicios_sector_editar"]:checked')).map((c) => {
            return c.value;
        });

        microserviciosUserEditar = microserviciosUserEditar.map(n => parseInt(n));

        const formData = new FormData(e.target);
        formData.append('accion', 'editar');
        formData.append('microservicios_sector_editar', microserviciosUserEditar);

        const response = await fetch('index.php?option=com_ajax&plugin=pluginMicroservicios&format=json', {
            method:'POST', //utilizado por compatibilidad con FormData
            body: formData
        })
        
        const jsonResponse = await response.json();

        if(jsonResponse.success){
            alert('Datos Editados Correctamente');
            location.reload();
        } else {
            console.log(jsonResponse)
            alert('error');
        }
    })
})