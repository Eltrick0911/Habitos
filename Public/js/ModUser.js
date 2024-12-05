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
      url: 'http://localhost/Habitos/api-rest/api/procesar_login.php',
      type: 'POST',
      contentType: 'application/json',
      data: JSON.stringify({
        email: email,
        password: password
      }),
      xhrFields: {
        withCredentials: true
      },
      crossDomain: true,
      success: function(response) {
        if (response.success) {
          sessionStorage.setItem('usuario_id', response.usuario_id);
          sessionStorage.setItem('nombre_completo', response.nombre_completo);
          
          if (response.tipo_usuario === 'admin') {
            window.location.href = 'http://127.0.0.1:5501/src/Routes/views/Administrador.HTML';
          } else {
            window.location.href = 'http://127.0.0.1:5501/src/Routes/views/index.html';
          }
        } else {
          alert('Error: ' + (response.error || 'Credenciales inválidas'));
        }
      },
      error: function(xhr, status, error) {
        console.error('Error:', error);
        console.error('Estado:', status);
        console.error('Respuesta:', xhr.responseText);
        alert('Error al iniciar sesión. Por favor, intenta nuevamente.');
      }
    });
  });
});