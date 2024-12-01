$(document).ready(function() {
    $("#btnLogin").click(function() {
      cargarContenido("../Src/Routes/views/login.html");
    });
  
    $("#btnRegister").click(function() {
      cargarContenido("../Src/Routes/views/register.html");
    });
  
    function cargarContenido(url) {
      $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
          $("#contenidoDinamico").html(response);
        },
        error: function() {
          alert("Error al cargar el contenido.");
        }
      });
    }
    function cargarContenido(url) {
      $.ajax({
        url: url,
        type: 'GET',
        success: function(response) {
          $("#contenidoDinamico").html(response);
          $(".info").hide(); // Agrega esta línea para ocultar el mensaje
        },
        error: function() {
          alert("Error al cargar el contenido.");
        }
      });
    }
  });
