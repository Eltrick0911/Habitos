$(document).ready(function() {
    // Manejar clic en el logo
    $("#logo").click(function() {
      cargarContenido("../../Routes/views/Administrador.HTML"); // Asegúrate de que esta sea la ruta correcta a tu archivo admin.html
    });
  
    const usuariosCard = document.getElementById('usuariosCard');
    const habitosCard = document.getElementById('habitosCard');
    const totalUsuarios = document.getElementById('totalUsuarios');
    const totalHabitos = document.getElementById('totalHabitos');
    const listaUsuarios = document.getElementById('listaUsuarios');
    const listaHabitos = document.getElementById('listaHabitos');
    const contenidoDinamico = document.getElementById('contenidoDinamico');
  
    // Datos de muestra para usuarios (incluyendo ID)
    const usuarios = [
      { id_usuario: 1, nombre: 'Juan', apellidos: 'Pérez', correo_electronico: 'juan.perez@example.com' },
      { id_usuario: 2, nombre: 'María', apellidos: 'García', correo_electronico: 'maria.garcia@example.com' },
      { id_usuario: 3, nombre: 'Pedro', apellidos: 'López', correo_electronico: 'pedro.lopez@example.com' }
    ];
  
    // Datos de muestra para hábitos (incluyendo ID)
    const habitos = [
      { id_habito: 1, nombre_habito: 'Ejercicio', categoria_habito: 'Salud' },
      { id_habito: 2, nombre_habito: 'Lectura', categoria_habito: 'Educación' },
      { id_habito: 3, nombre_habito: 'Meditación', categoria_habito: 'Bienestar' }
    ];
  
    // Mostrar el total de usuarios y hábitos al cargar la página
    totalUsuarios.textContent = usuarios.length;
    totalHabitos.textContent = habitos.length;
  
    // Función para mostrar la lista de usuarios
    function mostrarListaUsuarios() {
      listaUsuarios.innerHTML = '';
  
      usuarios.forEach(usuario => {
        const li = document.createElement('li');
        li.innerHTML = `ID: ${usuario.id_usuario} - ${usuario.nombre} ${usuario.apellidos} (${usuario.correo_electronico}) 
                        <button class="modificar-usuario" data-id="${usuario.id_usuario}">Modificar</button>`;
        listaUsuarios.appendChild(li);
      });
  
      // Agregar evento a los botones de modificar usuario
      const botonesModificar = document.querySelectorAll('.modificar-usuario');
      botonesModificar.forEach(boton => {
        boton.addEventListener('click', () => {
          const usuarioId = boton.dataset.id;
          cargarContenido("../../Routes/views/ModificarUsuario.HTML", usuarioId);
        });
      });
    }
  
    // Función para mostrar la lista de hábitos
    function mostrarListaHabitos() {
      listaHabitos.innerHTML = '';
  
      habitos.forEach(habito => {
        const li = document.createElement('li');
        li.innerHTML = `ID: ${habito.id_habito} - ${habito.nombre_habito} (${habito.categoria_habito}) 
                        <button class="modificar-habito" data-id="${habito.id_habito}">Modificar</button>`;
        listaHabitos.appendChild(li);
      });
  
      // Agregar evento a los botones de modificar hábito
      const botonesModificarHabito = document.querySelectorAll('.modificar-habito');
      botonesModificarHabito.forEach(boton => {
        boton.addEventListener('click', () => {
          const habitoId = boton.dataset.id;
          cargarContenido("../../Routes/views/ModificarHabito.html", habitoId);
        });
      });
    }
  
    // Función para cargar contenido con AJAX
    function cargarContenido(url, id) {
      $.ajax({
        url: url,
        type: 'GET',
        data: {
          id: id
        },
        success: function(response) {
          // Si se está cargando admin.html, reemplazar todo el contenido
          if (url === "../../Routes/views/Administrador.HTML") {
            $("body").empty();
            $("body").html(response);
  
            // Volver a inicializar los eventos del panel de administrador
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
      // Manejar clic en el logo (volver a agregarlo después de la carga AJAX)
      $("#logo").click(function() {
        cargarContenido("../../Routes/views/Administrador.HTML");
      });
  
      // Agregar eventos a los recuadros
      usuariosCard.addEventListener('click', mostrarListaUsuarios);
      habitosCard.addEventListener('click', mostrarListaHabitos);
    }
  
    // Inicializar el panel al cargar la página
    inicializarPanelAdministrador();
  });