let tablaUsuarios, tablaHabitos, tablaComentarios;

$(document).ready(function() {
    // Inicializar DataTables solo si no están ya inicializadas
    if (!$.fn.DataTable.isDataTable('#tablaUsuarios')) {
        tablaUsuarios = $('#tablaUsuarios').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            columns: [
                { data: 'id' },
                { data: 'nombre' },
                { data: 'email' },
                { data: 'fecha_registro' },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                            <button onclick="editarUsuario(${row.id})" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="eliminarUsuario(${row.id})" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        `;
                    }
                }
            ]
        });
    }

    if (!$.fn.DataTable.isDataTable('#tablaHabitos')) {
        tablaHabitos = $('#tablaHabitos').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            columns: [
                { data: 'id' },
                { data: 'titulo' },
                { data: 'descripcion' },
                { data: 'usuario' },
                { data: 'fecha_creacion' },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                            <button onclick="editarHabito(${row.id})" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="eliminarHabito(${row.id})" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        `;
                    }
                }
            ]
        });
    }

    if (!$.fn.DataTable.isDataTable('#tablaComentarios')) {
        tablaComentarios = $('#tablaComentarios').DataTable({
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json'
            },
            columns: [
                { data: 'id' },
                { data: 'comentario' },
                { data: 'usuario' },
                { data: 'habito' },
                { data: 'fecha_creacion' },
                {
                    data: null,
                    render: function(data, type, row) {
                        return `
                            <button onclick="eliminarComentario(${row.id})" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        `;
                    }
                }
            ]
        });
    }

    // Cargar datos iniciales
    cargarDatos();
    
    // Event Listeners
    $('#btnNuevoUsuario').click(function() {
        limpiarFormularioUsuario();
        $('#modalUsuarioLabel').text('Nuevo Usuario');
        $('#modalUsuario').modal('show');
    });
    
    $('#btnNuevoHabito').click(function() {
        limpiarFormularioHabito();
        $('#modalHabitoLabel').text('Nuevo Hábito');
        cargarUsuariosSelect();
        $('#modalHabito').modal('show');
    });
    
    $('#formUsuario').submit(function(e) {
        e.preventDefault();
        guardarUsuario();
    });
    
    $('#formHabito').submit(function(e) {
        e.preventDefault();
        guardarHabito();
    });
});

// Funciones de carga de datos
function cargarDatos() {
    cargarUsuarios();
    cargarHabitos();
    cargarComentarios();
    actualizarContadores();
}

function cargarUsuarios() {
    $.ajax({
        url: "http://localhost/Habitos/bd/crud_usuarios.php?operacion=consultar",
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.success && tablaUsuarios) {
                tablaUsuarios.clear().rows.add(response.data).draw();
            } else {
                mostrarError('Error al cargar usuarios: ' + (response.message || 'Error desconocido'));
            }
        },
        error: function() {
            mostrarError('Error en la conexión al cargar usuarios');
        }
    });
}

function cargarHabitos() {
    $.ajax({
        url: "http://localhost/Habitos/bd/crud_habitos.php?operacion=consultar",
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.success && tablaHabitos) {
                tablaHabitos.clear().rows.add(response.data).draw();
            } else {
                mostrarError('Error al cargar hábitos: ' + (response.message || 'Error desconocido'));
            }
        },
        error: function() {
            mostrarError('Error en la conexión al cargar hábitos');
        }
    });
}

function cargarComentarios() {
    $.ajax({
        url: "http://localhost/Habitos/bd/crud_comentarios.php?operacion=consultar",
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if(response.success && tablaComentarios) {
                tablaComentarios.clear().rows.add(response.data).draw();
            } else {
                mostrarError('Error al cargar comentarios: ' + (response.message || 'Error desconocido'));
            }
        },
        error: function() {
            mostrarError('Error en la conexión al cargar comentarios');
        }
    });
}

function cargarUsuariosSelect() {
    $.ajax({
        url: '../../bd/crud_usuarios.php?operacion=consultar',
        type: 'GET',
        success: function(response) {
            if(response.success) {
                const select = $('#usuario');
                select.empty();
                select.append('<option value="">Seleccione un usuario</option>');
                response.data.forEach(function(usuario) {
                    select.append(`<option value="${usuario.id}">${usuario.nombre}</option>`);
                });
            }
        },
        error: function() {
            mostrarError('Error al cargar usuarios');
        }
    });
}

function actualizarContadores() {
    $.ajax({
        url: "http://localhost/Habitos/bd/crud_contadores.php",
        type: 'GET',
        dataType: 'json',
        success: function(data) {
            if (data.success) {
                $("#totalUsuarios").text(data.data.usuarios);
                $("#totalHabitos").text(data.data.habitos);
                $("#totalComentarios").text(data.data.comentarios);
            } else {
                console.error('Error en la respuesta:', data.message);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            console.error('Error en la petición de contadores:', textStatus, errorThrown);
        }
    });
}

// Funciones de gestión de usuarios
function guardarUsuario() {
    const usuario = {
        nombre: $('#nombre').val(),
        email: $('#email').val(),
        password: $('#password').val()
    };
    
    const id = $('#idUsuario').val();
    const operacion = id ? 'actualizar' : 'crear';
    
    if(id) usuario.id = id;
    
    $.ajax({
        url: '../../bd/crud_usuarios.php?operacion=' + operacion,
        type: 'POST',
        data: JSON.stringify(usuario),
        contentType: 'application/json',
        success: function(response) {
            if(response.success) {
                $('#modalUsuario').modal('hide');
                cargarUsuarios();
                actualizarContadores();
                mostrarExito('Usuario guardado correctamente');
            } else {
                mostrarError(response.message || 'Error al guardar usuario');
            }
        },
        error: function() {
            mostrarError('Error al guardar usuario');
        }
    });
}

function editarUsuario(id) {
    $.ajax({
        url: `../../bd/crud_usuarios.php?operacion=consultar&id=${id}`,
        type: 'GET',
        success: function(response) {
            if(response.success) {
                const usuario = response.data;
                $('#idUsuario').val(usuario.id);
                $('#nombre').val(usuario.nombre);
                $('#email').val(usuario.email);
                $('#password').val('');
                $('#modalUsuarioLabel').text('Editar Usuario');
                $('#modalUsuario').modal('show');
            }
        },
        error: function() {
            mostrarError('Error al cargar usuario');
        }
    });
}

function eliminarUsuario(id) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../../bd/crud_usuarios.php?operacion=eliminar',
                type: 'POST',
                data: JSON.stringify({ id: id }),
                contentType: 'application/json',
                success: function(response) {
                    if(response.success) {
                        cargarUsuarios();
                        actualizarContadores();
                        mostrarExito('Usuario eliminado correctamente');
                    } else {
                        mostrarError(response.message || 'Error al eliminar usuario');
                    }
                },
                error: function() {
                    mostrarError('Error al eliminar usuario');
                }
            });
        }
    });
}

// Funciones de gestión de hábitos
function guardarHabito() {
    const habito = {
        titulo: $('#titulo').val(),
        descripcion: $('#descripcion').val(),
        usuario_id: $('#usuario').val()
    };
    
    const id = $('#idHabito').val();
    const operacion = id ? 'actualizar' : 'crear';
    
    if(id) habito.id = id;
    
    $.ajax({
        url: '../../bd/crud_habitos.php?operacion=' + operacion,
        type: 'POST',
        data: JSON.stringify(habito),
        contentType: 'application/json',
        success: function(response) {
            if(response.success) {
                $('#modalHabito').modal('hide');
                cargarHabitos();
                actualizarContadores();
                mostrarExito('Hábito guardado correctamente');
            } else {
                mostrarError(response.message || 'Error al guardar hábito');
            }
        },
        error: function() {
            mostrarError('Error al guardar hábito');
        }
    });
}

function editarHabito(id) {
    $.ajax({
        url: `../../bd/crud_habitos.php?operacion=consultar&id=${id}`,
        type: 'GET',
        success: function(response) {
            if(response.success) {
                const habito = response.data;
                $('#idHabito').val(habito.id);
                $('#titulo').val(habito.titulo);
                $('#descripcion').val(habito.descripcion);
                cargarUsuariosSelect();
                $('#usuario').val(habito.usuario_id);
                $('#modalHabitoLabel').text('Editar Hábito');
                $('#modalHabito').modal('show');
            }
        },
        error: function() {
            mostrarError('Error al cargar hábito');
        }
    });
}

function eliminarHabito(id) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../../bd/crud_habitos.php?operacion=eliminar',
                type: 'POST',
                data: JSON.stringify({ id: id }),
                contentType: 'application/json',
                success: function(response) {
                    if(response.success) {
                        cargarHabitos();
                        actualizarContadores();
                        mostrarExito('Hábito eliminado correctamente');
                    } else {
                        mostrarError(response.message || 'Error al eliminar hábito');
                    }
                },
                error: function() {
                    mostrarError('Error al eliminar hábito');
                }
            });
        }
    });
}

// Funciones de gestión de comentarios
function eliminarComentario(id) {
    Swal.fire({
        title: '¿Está seguro?',
        text: "Esta acción no se puede deshacer",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../../bd/crud_comentarios.php?operacion=eliminar',
                type: 'POST',
                data: JSON.stringify({ id: id }),
                contentType: 'application/json',
                success: function(response) {
                    if(response.success) {
                        cargarComentarios();
                        actualizarContadores();
                        mostrarExito('Comentario eliminado correctamente');
                    } else {
                        mostrarError(response.message || 'Error al eliminar comentario');
                    }
                },
                error: function() {
                    mostrarError('Error al eliminar comentario');
                }
            });
        }
    });
}

// Funciones de utilidad
function limpiarFormularioUsuario() {
    $('#idUsuario').val('');
    $('#nombre').val('');
    $('#email').val('');
    $('#password').val('');
}

function limpiarFormularioHabito() {
    $('#idHabito').val('');
    $('#titulo').val('');
    $('#descripcion').val('');
    $('#usuario').val('');
}

function mostrarExito(mensaje) {
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: mensaje,
        timer: 2000,
        showConfirmButton: false
    });
}

function mostrarError(mensaje) {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: mensaje,
        timer: 3000,
        showConfirmButton: false
    });
}
