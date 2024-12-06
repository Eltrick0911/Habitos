$(document).ready(function() {
    // Verificar si hay usuario logueado
    const usuario_id = sessionStorage.getItem('usuario_id');
    if (!usuario_id) {
        alert('Debe iniciar sesión para agregar hábitos');
        window.location.href = '/Habitos/login.html';
        return;
    }

    $('#habitForm').submit(function(event) {
        event.preventDefault();

        // Validaciones básicas
        if (!$('#nombre_habito').val().trim()) {
            alert("Por favor, ingresa el nombre del hábito.");
            return;
        }

        if (!$('#fecha_inicio').val()) {
            alert("Por favor, selecciona la fecha de inicio.");
            return;
        }

        // Crear objeto con los datos del formulario
        const datosHabito = {
            nombre_habito: $('#nombre_habito').val().trim(),
            descripcion_habito: $('#descripcion_habito').val().trim(),
            categoria_habito: $('#categoria_habito').val(),
            objetivo_habito: $('#objetivo_habito').val().trim(),
            frecuencia: $('#frecuencia').val(),
            duracion_estimada: $('#duracion_estimada').val(),
            estado: $('#estado').val(),
            fecha_inicio: $('#fecha_inicio').val(),
            fecha_estimacion_final: $('#fecha_estimacion_final').val(),
            usuario_id: sessionStorage.getItem('usuario_id')
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
            success: function(response) {
                if (response.status === 'success') {
                    alert('¡Hábito agregado exitosamente!');
                    window.location.href = '/Habitos/src/Routes/views/index.html';
                } else {
                    alert('Error al agregar el hábito: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                let mensaje = 'Error al agregar el hábito.';
                try {
                    const respuesta = JSON.parse(xhr.responseText);
                    mensaje += ' ' + (respuesta.message || '');
                } catch(e) {
                    mensaje += ' Por favor, intenta nuevamente.';
                }
                alert(mensaje);
            }
        });
    });

    // Configurar fechas mínimas
    const today = new Date().toISOString().split('T')[0];
    $('#fecha_inicio').attr('min', today);
    
    $('#fecha_inicio').change(function() {
        $('#fecha_estimacion_final').attr('min', $(this).val());
    });
});