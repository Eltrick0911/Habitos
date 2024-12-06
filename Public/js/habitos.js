$(document).ready(function() {
    const usuario_id = sessionStorage.getItem('usuario_id');
    if (!usuario_id) {
        alert('Debe iniciar sesión para ver sus hábitos');
        window.location.href = '/Habitos/login.html';
        return;
    }

    // Cargar hábitos
    $.ajax({
        url: `http://localhost/Habitos/api-rest/api/consultar_habito.php?usuario_id=${usuario_id}`,
        type: 'GET',
        xhrFields: {
            withCredentials: true
        },
        success: function(response) {
            if (response.status === 'success') {
                mostrarHabitos(response.data);
            } else {
                alert('Error al cargar los hábitos: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Error al cargar los hábitos');
        }
    });
});

function mostrarHabitos(habitos) {
    const container = $('#listaHabitos');
    container.empty();

    if (habitos.length === 0) {
        container.append('<p class="no-habitos">No tienes hábitos registrados aún.</p>');
        return;
    }

    habitos.forEach(habito => {
        const card = `
            <div class="habito-card">
                <div class="habito-header">
                    <span class="habito-titulo">${habito.nombre_habito}</span>
                    <span class="habito-estado estado-${habito.estado.toLowerCase()}">${habito.estado}</span>
                </div>
                <div class="habito-detalles">
                    <p><strong>Categoría:</strong> ${habito.categoria_habito}</p>
                    <p><strong>Frecuencia:</strong> ${habito.frecuencia}</p>
                    <p><strong>Objetivo:</strong> ${habito.objetivo_habito}</p>
                    <p><strong>Duración:</strong> ${habito.duracion_estimada} minutos</p>
                    <p><strong>Inicio:</strong> ${habito.fecha_inicio}</p>
                    <p><strong>Fin estimado:</strong> ${habito.fecha_estimacion_final}</p>
                </div>
                <p><strong>Descripción:</strong> ${habito.descripcion_habito || 'Sin descripción'}</p>
                <button class="btn-modificar" onclick="cargarModificarHabito(${habito.id_habito})">
                    Modificar Hábito
                </button>
            </div>
        `;
        container.append(card);
    });
}

// Función para cargar la vista de modificar hábito
function cargarModificarHabito(id_habito) {
    console.log('Cargando modificar hábito con ID:', id_habito);
    
    if (!id_habito) {
        console.error('No se proporcionó ID del hábito');
        return;
    }

    sessionStorage.setItem('habito_id', id_habito);
    
    // Cargar el formulario en el contenedor
    $('#contenidoDinamico').load('/Habitos/src/Routes/views/ModificarHabito.html', function() {
        const usuario_id = sessionStorage.getItem('usuario_id');
        
        // Cargar los datos del hábito
        $.ajax({
            url: 'http://localhost/Habitos/api-rest/api/consultar_habito.php',
            type: 'GET',
            data: {
                id: id_habito,
                usuario_id: usuario_id
            },
            success: function(response) {
                console.log('Datos del hábito:', response);
                if (response && response.status === 'success' && response.data) {
                    const habito = response.data[0]; // Tomar el primer elemento del array
                    console.log('Datos a cargar en el formulario:', habito); // Debug

                    // Asegurar que el id_habito se establezca correctamente
                    $('#id_habito').val(id_habito);
                    $('#nombre_habito').val(habito.nombre_habito || '');
                    $('#descripcion_habito').val(habito.descripcion_habito || '');
                    $('#categoria_habito').val(habito.categoria_habito || 'sueño');
                    $('#objetivo_habito').val(habito.objetivo_habito || '');
                    $('#frecuencia').val(habito.frecuencia || 'diaria');
                    $('#duracion_estimada').val(habito.duracion_estimada || '');
                    $('#estado').val(habito.estado || 'activo');
                    $('#fecha_inicio').val(formatearFecha(habito.fecha_inicio));
                    $('#fecha_estimacion_final').val(formatearFecha(habito.fecha_estimacion_final));
                }
            }
        });
    });
}

// Función para formatear la fecha
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

// Mantener solo este manejador de eventos global
$(document).on('submit', '#modificarHabitForm', function(e) {
    e.preventDefault();
    console.log('Enviando formulario de modificación...');

    const formData = {
        id_habito: $('#id_habito').val(),
        nombre_habito: $('#nombre_habito').val(),
        descripcion_habito: $('#descripcion_habito').val(),
        categoria_habito: $('#categoria_habito').val(),
        objetivo_habito: $('#objetivo_habito').val(),
        frecuencia: $('#frecuencia').val(),
        duracion_estimada: $('#duracion_estimada').val(),
        estado: $('#estado').val(),
        fecha_inicio: $('#fecha_inicio').val(),
        fecha_estimacion_final: $('#fecha_estimacion_final').val(),
        usuario_id: sessionStorage.getItem('usuario_id')
    };

    console.log('Datos a enviar:', formData);

    $.ajax({
        url: 'http://localhost/Habitos/api-rest/api/actualizar_habito.php',
        type: 'POST',
        data: JSON.stringify(formData),
        contentType: 'application/json',
        success: function(response) {
            console.log('Respuesta del servidor:', response);
            if (response.message) {
                alert('Hábito modificado exitosamente');
                cargarContenido('Habitos.html');
            } else {
                alert('Error al modificar el hábito: ' + (response.error || 'Error desconocido'));
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la petición:', {
                status: xhr.status,
                statusText: xhr.statusText,
                responseText: xhr.responseText
            });
            if (xhr.responseText.startsWith('<!DOCTYPE')) {
                console.error('La respuesta parece ser HTML en lugar de JSON.');
            }
            alert('Error al modificar el hábito');
        }
    });
});

function cargarContenido(pagina) {
    $.ajax({
        url: `/Habitos/src/Routes/views/${pagina}`,
        type: 'GET',
        success: function(html) {
            $('#contenidoDinamico').html(html);
            if (pagina === 'Habitos.html') {
                // Recargar la lista de hábitos
                cargarHabitos();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar la página:', error);
            alert('Error al cargar la página');
        }
    });
}

function cargarHabitos() {
    const usuario_id = sessionStorage.getItem('usuario_id');
    $.ajax({
        url: `http://localhost/Habitos/api-rest/api/consultar_habito.php?usuario_id=${usuario_id}`,
        type: 'GET',
        success: function(response) {
            if (response.status === 'success') {
                mostrarHabitos(response.data);
            } else {
                alert('Error al cargar los hábitos: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
            alert('Error al cargar los hábitos');
        }
    });
}