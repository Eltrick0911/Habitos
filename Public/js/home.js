$(document).ready(function() {
  $("#btnLogin").click(function() {
    $.ajax({
      url: "../src/Routes/views/login.html",
      type: 'GET',
      success: function(response) {
        $("#contenidoDinamico").html(response);
        $(".info").hide();
        
        if (!document.getElementById('loginStyles')) {
          var link = document.createElement('link');
          link.id = 'loginStyles';
          link.rel = 'stylesheet';
          link.href = './ccs/styles.css';
          document.head.appendChild(link);
        }
        
        if (!document.getElementById('modUserScript')) {
          var script = document.createElement('script');
          script.id = 'modUserScript';
          script.src = './js/ModUser.js';
          document.body.appendChild(script);
        }
      },
      error: function(error) {
        console.error('Error:', error);
        alert("Error al cargar el formulario de login.");
      }
    });
  });

  $("#btnRegister").click(function() {
    $.ajax({
      url: "../src/Routes/views/register.html",
      type: 'GET',
      success: function(response) {
        $("#contenidoDinamico").html(response);
        $(".info").hide();
      },
      error: function(error) {
        console.error('Error:', error);
        alert("Error al cargar el formulario de registro.");
      }
    });
  });
});