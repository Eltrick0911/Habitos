$(document).ready(function() {
    // Verificar autenticación
    const token = localStorage.getItem('jwt_token');
    const usuario_id = localStorage.getItem('usuario_id');
    
    if (!token || !usuario_id) {
        alert('Debe iniciar sesión para ver sus hábitos');
        window.location.href = '/Habitos/Public/Index.html';
        return;
    }

    // Cargar hábitos
    $.ajax({
        url: `http://localhost/Habitos/api-rest/api/consultar_habito.php?usuario_id=${usuario_id}`,
        type: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token
        },
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
    console.log('Mostrando hábitos:', habitos);
    
    const container = $('#listaHabitos');
    container.empty();

    if (habitos.length === 0) {
        container.append('<p class="no-habitos">No tienes hábitos registrados aún.</p>');
        return;
    }

    habitos.forEach(habito => {
        console.log('Procesando hábito:', habito);
        console.log('ID del hábito:', habito.id_habito);
        
        const card = `
            <div class="habito-card" data-id="${habito.id_habito}">
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
    if (!id_habito) {
        alert('Error: No se pudo identificar el hábito');
        return;
    }

    const token = localStorage.getItem('jwt_token');
    const usuario_id = localStorage.getItem('usuario_id');
    
    if (!token || !usuario_id) {
        alert('Debe iniciar sesión para modificar hábitos');
        window.location.href = '/Habitos/Public/Index.html';
        return;
    }

    // Primero almacenar el ID
    localStorage.setItem('habito_id_temp', id_habito);

    // Luego cargar el formulario
    $('#contenidoDinamico').load('/Habitos/src/Routes/views/ModificarHabito.html', function() {
        // Inicializar el script después de cargar el HTML
        $.getScript('/Habitos/Public/js/ModificarHabito.js')
        .fail(function(jqxhr, settings, exception) {
            console.error('Error al cargar el script:', exception);
            localStorage.removeItem('habito_id_temp'); // Limpiar en caso de error
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

// Actualizar el manejador del formulario
$(document).on('submit', '#modificarHabitForm', function(e) {
    e.preventDefault();
    const token = localStorage.getItem('jwt_token');
    
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
        usuario_id: localStorage.getItem('usuario_id')
    };

    $.ajax({
        url: 'http://localhost/Habitos/api-rest/api/actualizar_habito.php',
        type: 'PUT',
        headers: {
            'Authorization': 'Bearer ' + token,
            'Content-Type': 'application/json'
        },
        data: JSON.stringify(formData),
        success: function(response) {
            if (response.status === 'success') {
                alert('Hábito modificado exitosamente');
                window.location.href = '/Habitos/src/Routes/views/Habitos.html';
            } else {
                alert('Error al modificar el hábito: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error:', error);
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
    const token = localStorage.getItem('jwt_token');
    const usuario_id = localStorage.getItem('usuario_id');
    
    if (!token || !usuario_id) {
        console.error('No se encontró token o ID de usuario');
        return;
    }

    $.ajax({
        url: `http://localhost/Habitos/api-rest/api/consultar_habito.php?usuario_id=${usuario_id}`,
        type: 'GET',
        headers: {
            'Authorization': 'Bearer ' + token
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
}