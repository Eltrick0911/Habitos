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
      var datos = {
        nombre: $("#nombre").val(),
        apellidos: $("#apellido").val(),
        correo_electronico: $("#email").val(),
        contrasena: $("#password").val(),
        fecha_nacimiento: $("#fechaNacimiento").val(),
        genero: $("#genero").val(),
        pais_region: $("#pais_region").val(),
        nivel_suscripcion: $("#nivel_suscripcion").val(),
        preferencias_notificacion: $("#preferencias_notificacion").val()
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
          if (response.status === "success") {
            alert(response.message || "Usuario registrado exitosamente");
            // Usar una ruta absoluta desde la raíz
            window.location.href = 'http://localhost/Habitos/src/Routes/views/index.html';
          } else {
            alert("Error: " + (response.error || "Error desconocido"));
          }
        },
        error: function(xhr, status, error) {
          console.error('Error:', error);
          console.error('Estado:', status);
          console.error('Respuesta:', xhr.responseText);
          let errorMessage = "Error al enviar el formulario";
          try {
            const response = JSON.parse(xhr.responseText);
            errorMessage = response.error || error;
          } catch(e) {
            errorMessage = error;
          }
          alert(errorMessage);
        }
      });
    }
  });
});