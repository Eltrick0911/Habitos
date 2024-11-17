<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <div class="login-container">
        <h2>Inicio de Sesión</h2>
        <form id="loginForm" action="../index.php/login" method="POST">
            <div class="input-group">
                <label for="email">Correo Electrónico</label>
                <input type="email" id="email" name="email" required>
                <span class="error-message" id="emailError"></span>
            </div>
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required>
                <span class="error-message" id="passwordError"></span>
            </div>
            <button type="submit">Iniciar Sesión</button>
        </form>
    </div>
    <script src="../js/scripts.js"></script>
</body>
</html>