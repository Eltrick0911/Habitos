$(document).ready(function() {
  // Función para mostrar/ocultar mensajes de error
  function mostrarError(campoId, mensaje) {
    document.getElementById(campoId + "Error").textContent = mensaje;
    document.getElementById(campoId + "Error").style.display = "block";
  }

  function ocultarError(campoId) {
    document.getElementById(campoId + "Error").style.display = "none";
  }

  // Validaciones individuales
  function validarNombreApellido(valor, campoId) {
    var expRegNombreApellido = /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;
    if (!expRegNombreApellido.test(valor)) {
      mostrarError(campoId, "El campo solo debe contener letras y espacios.");
      return false;
    } else {
      ocultarError(campoId);
      return true;
    }
  }

  function validarCorreo(correo) {
    var expRegCorreo = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    if (!expRegCorreo.test(correo)) {
      mostrarError("email", "Por favor, ingrese un correo electrónico válido.");
      return false;
    } else {
      ocultarError("email");
      return true;
    }
  }

  function validarContrasena(contrasena) {
    var expRegContrasena = /^(?=.*[!@#$%^&*])(?=.{6,})/;
    if (!expRegContrasena.test(contrasena)) {
      mostrarError("password", "La contraseña debe tener al menos 6 caracteres y al menos un carácter especial.");
      return false;
    } else {
      ocultarError("password");
      return true;
    }
  }

  // Manejar el envío del formulario
  $("#formulario-registro").submit(function(event) {
    event.preventDefault();

    // Validar el formulario
    var nombreValido = validarNombreApellido(document.getElementById("nombre").value, "nombre");
    var apellidoValido = validarNombreApellido(document.getElementById("apellido").value, "apellido");
    var correoValido = validarCorreo(document.getElementById("email").value);
    var contrasenaValida = validarContrasena(document.getElementById("password").value);
    // ... (validar los demás campos) ...

    if (nombreValido && apellidoValido && correoValido && contrasenaValida /* && ... (otras validaciones) ... */ ) {
      // Obtener los valores del formulario
      var nombre = $("#nombre").val();
      var apellidos = $("#apellido").val();
      var correo_electronico = $("#email").val();
      var contrasena = $("#password").val();
      var fecha_nacimiento = $("#fechaNacimiento").val();
      var genero = $("#genero").val();
      var pais_region = $("#pais_region").val();  // Asegúrate de que este campo exista en tu formulario
      var nivel_suscripcion = $("#nivel_suscripcion").val(); // Asegúrate de que este campo exista en tu formulario
      var preferencias_notificacion = $("#preferencias_notificacion").val(); // Asegúrate de que este campo exista en tu formulario


      // Crear un objeto con los datos del formulario
      var datos = {
        nombre: nombre,
        apellidos: apellidos,
        correo_electronico: correo_electronico,
        contrasena: contrasena,
        fecha_nacimiento: fecha_nacimiento,
        genero: genero,
        pais_region: pais_region,  // Incluir pais_region en los datos
        nivel_suscripcion: nivel_suscripcion,  // Incluir nivel_suscripcion en los datos
        preferencias_notificacion: preferencias_notificacion  // Incluir preferencias_notificacion en los datos
      };

      // Realizar la petición AJAX
      $.ajax({
        url: '../../api-rest/api/registrar_usuario.php', // Ajusta la ruta si es necesario
        type: 'POST',
        data: JSON.stringify(datos),
        contentType: 'application/json',
        success: function(response) {
          // Mostrar la respuesta del servidor
          alert(response.message || response.error);

          // Redirigir a index.html si el registro fue exitoso
          if (response.message) {
            window.location.href = '/src/Routes/views/index.html'; // Ajusta la ruta si es necesario
          }
        },
        error: function() {
          alert("Error al enviar el formulario.");
        }
      });
    }
  });
});