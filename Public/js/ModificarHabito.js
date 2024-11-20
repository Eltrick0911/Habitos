document.getElementById('modificarHabitForm').addEventListener('submit', function(event) {
    event.preventDefault();
  
    // Obtener los valores de los campos del formulario
    let idHabito = document.getElementById('id_habito').value;
    let nombreHabito = document.getElementById('nombre_habito').value;
    let descripcionHabito = document.getElementById('descripcion_habito').value;
    let categoriaHabito = document.getElementById('categoria_habito').value;
    let objetivoHabito = document.getElementById('objetivo_habito').value;
    let frecuencia = document.getElementById('frecuencia').value;
    let duracionEstimada = document.getElementById('duracion_estimada').value;
    let estado = document.getElementById('estado').value;
    let fechaInicio = document.getElementById('fecha_inicio').value;
    let fechaEstimacionFinal = document.getElementById('fecha_estimacion_final').value;
  
    // Validaciones (puedes agregar más validaciones aquí)
    if (nombreHabito.trim() === "") {
      alert("Por favor, ingresa el nombre del hábito.");
      return;
    }
  
    // Preparar los datos para enviar al servidor
    let formData = new FormData();
    formData.append('id_habito', idHabito);
    formData.append('nombre_habito', nombreHabito);
    formData.append('descripcion_habito', descripcionHabito);
    formData.append('categoria_habito', categoriaHabito);
    formData.append('objetivo_habito', objetivoHabito);
    formData.append('frecuencia', frecuencia);
    formData.append('duracion_estimada', duracionEstimada);
    formData.append('estado', estado);
    formData.append('fecha_inicio', fechaInicio);
    formData.append('fecha_estimacion_final', fechaEstimacionFinal);
  
    // Enviar los datos al servidor usando fetch (o AJAX)
    fetch('modificar_habito.php', {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert("Hábito modificado correctamente.");
        // Puedes redirigir a otra página o actualizar la página actual
      } else {
        alert("Error al modificar el hábito.");
      }
    })
    .catch(error => {
      console.error('Error:', error);
      alert("Error al modificar el hábito.");
    });
  });
  
  // Puedes agregar un evento similar para el formulario de eliminar hábito