document.getElementById('usuarioForm').addEventListener('submit', function(event) {
    event.preventDefault();
  
    // Obtener los valores de los campos del formulario
    let nombre = document.getElementById('nombre').value;
    let apellidos = document.getElementById('apellidos').value;
    let correoElectronico = document.getElementById('correo_electronico').value;
    let contrasena = document.getElementById('contrasena').value;
    let fechaNacimiento = document.getElementById('fecha_nacimiento').value;
    let genero = document.getElementById('genero').value;
    let paisRegion = document.getElementById('pais_region').value;
    let nivelSuscripcion = document.getElementById('nivel_suscripcion').value;
    let preferenciasNotificacion = document.getElementById('preferencias_notificacion').value;
  
    // Validaciones
    let isValid = true;
  
    // Validar nombre (requerido y solo letras)
    if (nombre.trim() === "" || !/^[a-zA-Z]+$/.test(nombre)) {
      alert("Por favor, ingresa un nombre válido (solo letras).");
      isValid = false;
    }
  
    // Validar apellidos (requerido y solo letras)
    if (apellidos.trim() === "" || !/^[a-zA-Z]+$/.test(apellidos)) {
      alert("Por favor, ingresa apellidos válidos (solo letras).");
      isValid = false;
    }
  
    // Validar correo electrónico (requerido y formato válido)
    if (correoElectronico.trim() === "" || !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(correoElectronico)) {
      alert("Por favor, ingresa un correo electrónico válido.");
      isValid = false;
    }
  
    // Validar contraseña (opcional, pero al menos 6 caracteres si se ingresa)
    if (contrasena.trim() !== "" && contrasena.length < 6) {
      alert("La contraseña debe tener al menos 6 caracteres.");
      isValid = false;
    }
  
    // Validar fecha de nacimiento (opcional, pero formato válido si se ingresa)
    if (fechaNacimiento.trim() !== "" && !/^\d{4}-\d{2}-\d{2}$/.test(fechaNacimiento)) {
      alert("Por favor, ingresa una fecha de nacimiento válida (YYYY-MM-DD).");
      isValid = false;
    }
  
    // Si todas las validaciones son correctas, enviar el formulario
    if (isValid) {
      // Aquí iría el código para enviar el formulario al servidor (fetch o AJAX)
      // ...
      alert("Formulario enviado correctamente.");
    }
  });