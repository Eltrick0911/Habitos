function validarRegistro() {
    var nombre = document.getElementById("nombre").value;
    var apellido = document.getElementById("apellido").value;
    var correo = document.getElementById("email").value;
    var contrasena = document.getElementById("password").value;
    var genero = document.getElementById("genero").value;
    var fechaNacimiento = document.getElementById("fechaNacimiento").value;
  
    // Validar nombre y apellido (solo letras y espacios)
    var expRegNombreApellido = /^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/;
    if (!expRegNombreApellido.test(nombre)) {
      document.getElementById("nombreError").textContent = "El nombre solo debe contener letras y espacios.";
      document.getElementById("nombreError").style.display = "block";
      return false;
    } else {
      document.getElementById("nombreError").style.display = "none";
    }
    if (!expRegNombreApellido.test(apellido)) {
      document.getElementById("apellidoError").textContent = "El apellido solo debe contener letras y espacios.";
      document.getElementById("apellidoError").style.display = "block";
      return false;
    } else {
      document.getElementById("apellidoError").style.display = "none";
    }
  
    // Validar correo electrónico
    var expRegCorreo = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/;
    if (!expRegCorreo.test(correo)) {
      document.getElementById("emailError").textContent = "Por favor, ingrese un correo electrónico válido.";
      document.getElementById("emailError").style.display = "block";
      return false;
    } else {
      document.getElementById("emailError").style.display = "none";
    }
  
    // Validar contraseña (mayor a 6 elementos y al menos y debe ser especial)
    var expRegContrasena = /^(?=.*[!@#$%^&*])(?=.{6,})/;
    if (!expRegContrasena.test(contrasena)) {
      document.getElementById("passwordError").textContent = "La contraseña debe tener al menos 6 caracteres y al menos un carácter especial.";
      document.getElementById("passwordError").style.display = "block";
      return false;
    } else {
      document.getElementById("passwordError").style.display = "none";
    }
  
    // Validar género
    if (genero === "") {
      document.getElementById("generoError").textContent = "Selecciona un género.";
      document.getElementById("generoError").style.display = "block";
      return false;
    } else {
      document.getElementById("generoError").style.display = "none";
    }
  
    // Validar fecha de nacimiento
    if (fechaNacimiento === "") {
      document.getElementById("fechaNacimientoError").textContent = "Por favor, ingrese su fecha de nacimiento.";
      document.getElementById("fechaNacimientoError").style.display = "block";
      return false;
    } else {
      document.getElementById("fechaNacimientoError").style.display = "none";
    }
  
    // Si todas las validaciones pasan, el formulario se enviará
    return true;
  }