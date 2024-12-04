$(document).ready(function() {
  // Manejar el envío del formulario
  $("#loginForm").submit(function(event) {
    event.preventDefault(); // Evitar que el formulario se envíe de forma tradicional

    // Obtener los valores del formulario
    var email = $("#email").val();
    var password = $("#password").val();

    // Validar el formulario (puedes agregar más validaciones si es necesario)
    if (email.trim() === "" || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
      alert("Por favor, ingresa un correo electrónico válido.");
      return false;
    }

    if (password.trim() === "") {
      alert("Por favor, ingresa tu contraseña.");
      return false;
    }

    // Crear un objeto con los datos del formulario
    var datos = {
      email: email,
      password: password
    };

    // Realizar la petición AJAX
    $.ajax({
      url: '../api_rest/api/procesar_login.php',
      type: 'POST',
      data: datos, // Enviar los datos como datos de formulario
      success: function(response) {
        // Manejar la respuesta del servidor
        try {
          var respuesta = JSON.parse(response); // Intentar analizar la respuesta como JSON

          if (respuesta.hasOwnProperty('error')) {
            // Mostrar mensaje de error
            alert(respuesta.error);
          } else {
            // Redirigir al usuario según su rol
            if (respuesta.tipo_usuario === 'admin') {
              window.location.href = '/Habitos/src/Routes/views/admin.html';
            } else {
              window.location.href = '/Habitos/src/Routes/views/index.html';
            }
          }
        } catch (error) {
          // Si la respuesta no es JSON, mostrarla como texto
          alert(response);
        }
      },
      error: function() {
        alert("Error al enviar el formulario.");
      }
    });
  });
});