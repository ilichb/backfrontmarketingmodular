
document.addEventListener('DOMContentLoaded', () => {
    let form = document.getElementById('microservicios-form');
    
    form.addEventListener('submit', (e) => {
    e.preventDefault();
    let sectorEconomico = document.getElementById('microservicios-select').value;
    let microserviciosUser = Array.from(document.querySelectorAll('input[name="microservicios_checkboxes[]"]:checked')).map((c) => {
         return c.value;
    });
    let texto = document.getElementById('microservicios-input').value;

    
    let data = new FormData(e.target);
    

    console.log(data)

    fetch('index.php?option=com_ajax&plugin=pluginMicroservicios&format=json', {
        method: 'POST',
        body: data,
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        }
    })
    .then(response => {
        if (response.status === 200) {
            console.log(response.clone().json())
            return response.json();
        } else {
            throw new Error('Error guardar los datos');
        }
    })
    .then(data => {
        console.log(data);
        if(data.success){
            console.log(data.data);
            alert('Datos guardados correctamente');
        } else {
            alert('Error alaaa guardar los datos');
        }
    })
    .catch(err => {
        console.log(err)
        alert(err.message);
        
    })
});
});
