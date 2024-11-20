document.getElementById('habitForm').addEventListener('submit', function(event) {
    event.preventDefault(); 
  
    // Validación del nombre del hábito (requerido)
    let nombreHabito = document.getElementById('nombre_habito').value;
    if (nombreHabito.trim() === "") {
      alert("Por favor, ingresa el nombre del hábito.");
      return;
    }
  
    // Validación de la fecha de inicio (requerida)
    let fechaInicio = document.getElementById('fecha_inicio').value;
    if (fechaInicio === "") {
      alert("Por favor, selecciona la fecha de inicio.");
      return;
    }
    alert('Hábito agregado!'); 
  });