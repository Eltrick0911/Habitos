<!DOCTYPE html>
<html>
<head>
  <title>Agregar Hábito</title>
  <link rel="stylesheet" href="../../../Public/ccs/Doscolumnas.css"> 
</head>
<body>
  <h1>Agregar Nuevo Hábito</h1>
  <div class="container"> 
    <form id="habitForm">
      <label for="nombre_habito">Nombre del Hábito:</label><br>
      <input type="text" id="nombre_habito" name="nombre_habito" required><br><br>

      <label for="descripcion_habito">Descripción:</label><br>
      <textarea id="descripcion_habito" name="descripcion_habito"></textarea><br><br>

      <label for="categoria_habito">Categoría:</label><br>
      <select id="categoria_habito" name="categoria_habito">
        <option value="sueño">Sueño</option>
        <option value="alimentacion">Alimentación</option>
        <option value="ejercicio">Ejercicio</option>
        <option value="estudio">Estudio</option>
        <option value="recreacion">Recreación</option>
        <option value="trabajo">Trabajo</option>
        <option value="hogar">Trabajos del Hogar</option>
        <option value="personal">Cuidado Personal</option>
        <option value="social">Social</option>
        <option value="finanzas">Finanzas</option>
      </select><br><br>

      <label for="objetivo_habito">Objetivo:</label><br>
      <input type="text" id="objetivo_habito" name="objetivo_habito"><br><br>

      <label for="frecuencia">Frecuencia:</label><br>
      <select id="frecuencia" name="frecuencia">
        <option value="diaria">Diaria</option>
        <option value="semanal">Semanal</option>
        <option value="quincenal">Quincenal</option>
        <option value="mensual">Mensual</option>
        <option value="bimestral">Bimestral</option>
        <option value="trimestral">Trimestral</option>
        <option value="semestral">Semestral</option>
        <option value="otro">Otro</option>
      </select><br><br>

      <label for="duracion_estimada">Duración Estimada (e.g., 30 minutos):</label><br>
      <input type="text" id="duracion_estimada" name="duracion_estimada"><br><br>

      <label for="estado">Estado:</label><br>
      <select id="estado" name="estado">
        <option value="pendiente">Pendiente</option>
        <option value="en progreso">En Progreso</option>
        <option value="completado">Completado</option>
      </select><br><br>

      <label for="fecha_inicio">Fecha de Inicio:</label><br>
      <input type="date" id="fecha_inicio" name="fecha_inicio"><br><br>

      <label for="fecha_estimacion_final">Fecha de Estimación Final:</label><br>
      <input type="date" id="fecha_estimacion_final" name="fecha_estimacion_final"><br><br>

      <button type="submit">Agregar Hábito</button>
    </form>
  </div> 

  <script src="../../../Public/js/agregarHabito.js"></script>
</body>
</html>