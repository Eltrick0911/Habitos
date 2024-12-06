$(document).ready(function() {
    // Intentar obtener el ID de múltiples fuentes
    const urlParams = new URLSearchParams(window.location.search);
    const id_habito = urlParams.get('id') || sessionStorage.getItem('habito_id');
    const usuario_id = sessionStorage.getItem('usuario_id');

    console.log('=== Debug ModificarHabito.js ===');
    console.log('ID del hábito:', id_habito);
    console.log('ID del usuario:', usuario_id);

    if (!id_habito || !usuario_id) {
        console.error('Falta ID del hábito o usuario');
        alert('Error: No se pudo identificar el hábito a modificar');
        window.location.href = '/Habitos/src/Routes/views/Habitos.html';
        return;
    }

    // Cargar los datos del hábito
    $.ajax({
        url: 'http://localhost/Habitos/api-rest/api/consultar_habito.php',
        type: 'GET',
        data: {
            id: id_habito,
            usuario_id: usuario_id
        },
        success: function(response) {
            console.log('Respuesta de consulta:', response);
            if (response && response.status === 'success' && response.data) {
                const habito = response.data[0]; // Tomar el primer elemento del array
                console.log('Datos a cargar en el formulario:', habito); // Debug
                $('#id_habito').val(id_habito); // Usar el ID original
                $('#nombre_habito').val(habito.nombre_habito);
                $('#descripcion_habito').val(habito.descripcion_habito);
                $('#categoria_habito').val(habito.categoria_habito);
                $('#objetivo_habito').val(habito.objetivo_habito);
                $('#frecuencia').val(habito.frecuencia);
                $('#duracion_estimada').val(habito.duracion_estimada);
                $('#estado').val(habito.estado);
                $('#fecha_inicio').val(formatearFecha(habito.fecha_inicio));
                $('#fecha_estimacion_final').val(formatearFecha(habito.fecha_estimacion_final));
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la petición:', {
                status: xhr.status,
                statusText: xhr.statusText,
                responseText: xhr.responseText
            });
        }
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