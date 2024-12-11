$(document).ready(function() {
  //Js Login
  // Función para mostrar/ocultar mensajes de error
  function mostrarError(campoId, mensaje) {
    document.getElementById(campoId + "Error").textContent = mensaje;
    document.getElementById(campoId + "Error").style.display = "block";
  }

  function ocultarError(campoId) {
    document.getElementById(campoId + "Error").style.display = "none";
  }

  // Validaciones
  function validarCorreo(correo) {
    var expRegCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!expRegCorreo.test(correo)) {
      mostrarError("email", "Por favor, ingrese un correo electrónico válido.");
      return false;
    } else {
      ocultarError("email");
      return true;
    }
  }

  function validarContrasena(contrasena) {
    if (contrasena.trim() === "") {
      mostrarError("password", "La contraseña no puede estar vacía.");
      return false;
    } else {
      ocultarError("password");
      return true;
    }
  }

  // Manejar el envío del formulario
  $("#loginForm").submit(function(event) {
    event.preventDefault();

    // Validar el formulario
    var correoValido = validarCorreo($("#email").val());
    var contrasenaValida = validarContrasena($("#password").val());

    if (correoValido && contrasenaValida) {
      // Obtener los valores del formulario
      var datos = {
        email: $("#email").val(),
        password: $("#password").val()
      };

      // Realizar la petición AJAX
      $.ajax({
        url: window.location.protocol + '//' + window.location.hostname + '/Habitos/api-rest/api/procesar_login.php',
        type: 'POST',
        data: JSON.stringify(datos),
        contentType: 'application/json',
        xhrFields: {
          withCredentials: true
        },
        success: function(response) {
          console.log('Respuesta exitosa:', response);
          if (response.success) {
            // Almacenar el token JWT
            localStorage.setItem('jwt_token', response.token);
            
            // Guardar datos del usuario
            localStorage.setItem('usuario_id', response.usuario_id);
            localStorage.setItem('nombre_completo', response.nombre_completo);
            localStorage.setItem('tipo_usuario', response.tipo_usuario);
            localStorage.setItem('email', response.email);
            
            // Redireccionar según el tipo de usuario
            if (response.tipo_usuario === 'admin') {
              window.location.href = 'http://localhost/Habitos/dashboard/index.php';
            } else {
              window.location.href = 'http://localhost/Habitos/src/Routes/views/index.html';
            }
          } else {
            alert("Error: " + (response.error || "Credenciales inválidas"));
          }
        },
        error: function(xhr, status, error) {
          console.error('Error detallado:', {
            error: error,
            status: status,
            responseText: xhr.responseText,
            statusCode: xhr.status
          });
          
          let errorMessage = "Error al iniciar sesión. ";
          try {
            const response = JSON.parse(xhr.responseText);
            errorMessage += response.error || error;
          } catch(e) {
            errorMessage += "No se pudo conectar con el servidor";
          }
          alert(errorMessage);
        }
      });
    }
  });
});