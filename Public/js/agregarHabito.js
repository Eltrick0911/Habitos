$(document).ready(function() {
    $('#habitForm').submit(function(event) {
        event.preventDefault();

        // Validaciones básicas
        let nombreHabito = $('#nombre_habito').val();
        if (nombreHabito.trim() === "") {
            alert("Por favor, ingresa el nombre del hábito.");
            return;
        }

        let fechaInicio = $('#fecha_inicio').val();
        if (fechaInicio === "") {
            alert("Por favor, selecciona la fecha de inicio.");
            return;
        }

        // Crear objeto con los datos del formulario
        const datosHabito = {
            nombre_habito: $('#nombre_habito').val(),
            descripcion_habito: $('#descripcion_habito').val(),
            categoria_habito: $('#categoria_habito').val(),
            objetivo_habito: $('#objetivo_habito').val(),
            frecuencia: $('#frecuencia').val(),
            duracion_estimada: $('#duracion_estimada').val(),
            estado: $('#estado').val(),
            fecha_inicio: $('#fecha_inicio').val(),
            fecha_estimacion_final: $('#fecha_estimacion_final').val()
        };

        // Enviar datos al servidor
        $.ajax({
            url: 'http://localhost/Habitos/api-rest/api/crear_habito.php',
            type: 'POST',
            contentType: 'application/json',
            data: JSON.stringify(datosHabito),
            xhrFields: {
                withCredentials: true
            },
            crossDomain: true,
            success: function(response) {
                if (response.status === 'success') {
                    alert('¡Hábito agregado exitosamente!');
                    window.location.href = '../views/index.html';
                } else {
                    alert('Error al agregar el hábito: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                console.error('Estado:', status);
                console.error('Respuesta:', xhr.responseText);
                
                let mensaje = 'Error al agregar el hábito.';
                if (xhr.responseText) {
                    try {
                        const respuesta = JSON.parse(xhr.responseText);
                        mensaje += ' ' + (respuesta.message || '');
                    } catch(e) {
                        mensaje += ' Por favor, intenta nuevamente.';
                    }
                }
                alert(mensaje);
            }
        });
    });

    // Validaciones adicionales
    $('#fecha_inicio').change(function() {
        let fechaInicio = new Date($(this).val());
        let fechaEstimacion = $('#fecha_estimacion_final');
        
        // Establecer la fecha mínima de estimación final
        fechaEstimacion.attr('min', $(this).val());
        
        // Si la fecha de estimación es anterior a la fecha de inicio, la limpiamos
        if (fechaEstimacion.val() && new Date(fechaEstimacion.val()) < fechaInicio) {
            fechaEstimacion.val('');
        }
    });

    // Establecer fecha mínima de inicio como hoy
    let today = new Date().toISOString().split('T')[0];
    $('#fecha_inicio').attr('min', today);
});