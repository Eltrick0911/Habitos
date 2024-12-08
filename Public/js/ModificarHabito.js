$(document).ready(function() {
    // Verificar autenticación
    const token = localStorage.getItem('jwt_token');
    const usuario_id = localStorage.getItem('usuario_id');
    
    console.log('Token:', token ? 'presente' : 'ausente');
    console.log('Usuario ID:', usuario_id);

    if (!token || !usuario_id) {
        alert('Debe iniciar sesión para modificar hábitos');
        window.location.href = '/Habitos/Public/Index.html';
        return;
    }

    // Obtener ID del hábito del almacenamiento temporal
    const id_habito = localStorage.getItem('habito_id_temp');
    console.log('ID del hábito obtenido:', id_habito);

    if (!id_habito) {
        alert('Error: No se pudo identificar el hábito a modificar');
        window.location.href = '/Habitos/src/Routes/views/index.html';
        return;
    }

    // Cargar los datos del hábito
    $.ajax({
        url: 'http://localhost/Habitos/api-rest/api/consultar_habito.php',
        type: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token
        },
        data: {
            id: id_habito,
            usuario_id: usuario_id
        },
        success: function(response) {
            console.log('Respuesta del servidor:', response);
            
            if (response && response.status === 'success' && response.data && response.data.length > 0) {
                const habito = response.data[0];
                console.log('Datos del hábito:', habito);

                // Llenar el formulario con los datos
                $('#id_habito').val(id_habito);
                $('#nombre_habito').val(habito.nombre_habito);
                $('#descripcion_habito').val(habito.descripcion_habito);
                $('#categoria_habito').val(habito.categoria_habito);
                $('#objetivo_habito').val(habito.objetivo_habito);
                $('#frecuencia').val(habito.frecuencia);
                $('#duracion_estimada').val(habito.duracion_estimada);
                $('#estado').val(habito.estado);
                $('#fecha_inicio').val(formatearFecha(habito.fecha_inicio));
                $('#fecha_estimacion_final').val(formatearFecha(habito.fecha_estimacion_final));

                // Limpiar el ID temporal después de usarlo
                localStorage.removeItem('habito_id_temp');
            } else {
                console.error('Datos inválidos en la respuesta:', response);
                alert('Error al cargar los datos del hábito');
                window.location.href = '/Habitos/src/Routes/views/index.html';
            }
        },
        error: function(xhr, status, error) {
            console.error('Error completo:', {
                status: xhr.status,
                statusText: xhr.statusText,
                responseText: xhr.responseText
            });
            if (xhr.status === 401) {
                alert('Sesión expirada. Por favor, inicie sesión nuevamente.');
                window.location.href = '/Habitos/Public/Index.html';
                return;
            }
            alert('Error al cargar los datos del hábito');
            window.location.href = '/Habitos/src/Routes/views/index.html';
        }
    });

    // Manejar el botón de eliminar
    $('#btnEliminar').click(function() {
        if (confirm('¿Está seguro de que desea eliminar este hábito?')) {
            const id_habito = $('#id_habito').val();
            
            $.ajax({
                url: 'http://localhost/Habitos/api-rest/api/eliminar_habito.php',
                type: 'DELETE',
                headers: {
                    'Authorization': 'Bearer ' + token,
                    'Content-Type': 'application/json'
                },
                data: JSON.stringify({ id_habito: id_habito }),
                success: function(response) {
                    if (response.status === 'success') {
                        alert('Hábito eliminado exitosamente');
                        window.location.href = '/Habitos/src/Routes/views/index.html';
                    } else {
                        alert('Error al eliminar el hábito: ' + response.message);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    alert('Error al eliminar el hábito');
                }
            });
        }
    });

    // Manejar el envío del formulario
    $('#habitForm').on('submit', function(event) {
        event.preventDefault();
        
        const datosHabito = {
            id_habito: $('#id_habito').val(),
            nombre_habito: $('#nombre_habito').val().trim(),
            descripcion_habito: $('#descripcion_habito').val().trim(),
            categoria_habito: $('#categoria_habito').val(),
            objetivo_habito: $('#objetivo_habito').val().trim(),
            frecuencia: $('#frecuencia').val(),
            duracion_estimada: $('#duracion_estimada').val(),
            estado: $('#estado').val(),
            fecha_inicio: $('#fecha_inicio').val(),
            fecha_estimacion_final: $('#fecha_estimacion_final').val(),
            usuario_id: usuario_id
        };

        $.ajax({
            url: 'http://localhost/Habitos/api-rest/api/actualizar_habito.php',
            type: 'POST',
            headers: {
                'Authorization': 'Bearer ' + token,
                'Content-Type': 'application/json'
            },
            data: JSON.stringify(datosHabito),
            success: function(response) {
                if (response.status === 'success') {
                    alert('¡Hábito actualizado exitosamente!');
                    window.location.href = '/Habitos/src/Routes/views/index.html';
                } else {
                    alert('Error al actualizar el hábito: ' + response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error completo:', {
                    status: xhr.status,
                    statusText: xhr.statusText,
                    responseText: xhr.responseText
                });
                if (xhr.status === 401) {
                    alert('Sesión expirada. Por favor, inicie sesión nuevamente.');
                    window.location.href = '/Habitos/Public/Index.html';
                    return;
                }
                alert('Error al actualizar el hábito');
            }
        });
    });
});

function formatearFecha(fecha) {
    if (!fecha) return '';
    try {
        const fechaObj = new Date(fecha);
        return fechaObj.toISOString().split('T')[0];
    } catch (error) {
        console.error('Error al formatear fecha:', error);
        return '';
    }
}