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
        url: 'http://localhost/Habitos/api-rest/api/registrar_usuario.php',
        type: 'POST',
        data: JSON.stringify(datos),
        contentType: 'application/json',
        xhrFields: {
          withCredentials: true
        },
        success: function(response) {
          console.log('Respuesta exitosa:', response);
          alert(response.message || "Usuario registrado exitosamente");
          // Redirección a index.html
          setTimeout(function() {
            window.location.replace('http://127.0.0.1:5501/src/Routes/views/index.html');
            // O si prefieres usar una ruta relativa:
            // window.location.replace('../../../src/Routes/views/index.html');
          }, 1000);
        },
        error: function(xhr, status, error) {
          console.error('Error:', error);
          console.error('Estado:', status);
          console.error('Respuesta:', xhr.responseText);
          alert("Error al enviar el formulario: " + error);
        }
      });
    }
  });
});