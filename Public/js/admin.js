$(document).ready(function() {
    $("#logo").click(function() {
        cargarContenido("../../Routes/views/Administrador.HTML");
    });
  
    const usuariosCard = document.getElementById('usuariosCard');
    const habitosCard = document.getElementById('habitosCard');
    const totalUsuarios = document.getElementById('totalUsuarios');
    const totalHabitos = document.getElementById('totalHabitos');
    const listaUsuarios = document.getElementById('listaUsuarios');
    const listaHabitos = document.getElementById('listaHabitos');
    const contenidoDinamico = document.getElementById('contenidoDinamico');

    // Función para cargar usuarios desde la base de datos
    function cargarUsuarios() {
        $.ajax({
            url: 'http://localhost/Habitos/api-rest/api/consultar_usuarios.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    totalUsuarios.textContent = response.data.length;
                    mostrarListaUsuarios(response.data);
                } else {
                    console.error('Error al cargar usuarios:', response.message);
                    totalUsuarios.textContent = '0';
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                totalUsuarios.textContent = 'Error';
            }
        });
    }

    // Función para cargar hábitos desde la base de datos
    function cargarHabitos() {
        $.ajax({
            url: 'http://localhost/Habitos/api-rest/api/consultar_todos_habitos.php',
            type: 'GET',
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    totalHabitos.textContent = response.data.length;
                    mostrarListaHabitos(response.data);
                } else {
                    console.error('Error al cargar hábitos:', response.message);
                    totalHabitos.textContent = '0';
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                totalHabitos.textContent = 'Error';
            }
        });
    }
  
    // Función para mostrar la lista de usuarios
    function mostrarListaUsuarios(usuarios) {
        listaUsuarios.innerHTML = '';
  
        usuarios.forEach(usuario => {
            const li = document.createElement('li');
            li.innerHTML = `
                <div class="usuario-item">
                    <div class="usuario-info">
                        <strong>ID:</strong> ${usuario.id_usuario} 
                        <strong>Nombre:</strong> ${usuario.nombre} ${usuario.apellidos}
                        <strong>Email:</strong> ${usuario.correo_electronico}
                    </div>
                    <button class="modificar-usuario btn-primary" data-id="${usuario.id_usuario}">
                        <i class="fas fa-edit"></i> Modificar
                    </button>
                </div>
            `;
            listaUsuarios.appendChild(li);
        });
  
        // Agregar evento a los botones de modificar usuario
        $('.modificar-usuario').click(function() {
            const usuarioId = $(this).data('id');
            cargarContenido("../../Routes/views/ModificarUsuario.HTML", usuarioId);
        });
    }
  
    // Función para mostrar la lista de hábitos
    function mostrarListaHabitos(habitos) {
        listaHabitos.innerHTML = '';
  
        habitos.forEach(habito => {
            const li = document.createElement('li');
            li.innerHTML = `
                <div class="habito-item">
                    <div class="habito-info">
                        <strong>ID:</strong> ${habito.id_habito}
                        <strong>Nombre:</strong> ${habito.nombre_habito}
                        <strong>Categoría:</strong> ${habito.categoria_habito || 'N/A'}
                    </div>
                    <button class="modificar-habito btn-primary" data-id="${habito.id_habito}">
                        <i class="fas fa-edit"></i> Modificar
                    </button>
                </div>
            `;
            listaHabitos.appendChild(li);
        });
  
        // Agregar evento a los botones de modificar hábito
        $('.modificar-habito').click(function() {
            const habitoId = $(this).data('id');
            cargarContenido("../../Routes/views/ModificarHabito.html", habitoId);
        });
    }
  
    // Función para cargar contenido con AJAX
    function cargarContenido(url, id) {
        $.ajax({
            url: url,
            type: 'GET',
            data: { id: id },
            success: function(response) {
                if (url === "../../Routes/views/Administrador.HTML") {
                    $("body").html(response);
                    inicializarPanelAdministrador();
                } else {
                    $("#contenidoDinamico").html(response);
                }
            },
            error: function() {
                alert("Error al cargar el contenido.");
            }
        });
    }
  
    // Función para inicializar los eventos del panel de administrador
    function inicializarPanelAdministrador() {
        $("#logo").click(function() {
            cargarContenido("../../Routes/views/Administrador.HTML");
        });
  
        // Cargar datos iniciales
        cargarUsuarios();
        cargarHabitos();
  
        // Agregar eventos a los recuadros
        usuariosCard.addEventListener('click', () => {
            if (listaUsuarios.children.length === 0) {
                cargarUsuarios();
            }
            $(listaUsuarios).slideToggle();
        });

        habitosCard.addEventListener('click', () => {
            if (listaHabitos.children.length === 0) {
                cargarHabitos();
            }
            $(listaHabitos).slideToggle();
        });
    }
  
    // Inicializar el panel al cargar la página
    inicializarPanelAdministrador();
});