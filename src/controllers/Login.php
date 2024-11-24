<?php
require_once __DIR__ . '/../../vendor/autoload.php';

use App\Models\userModel;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo_electronico = $_POST['email'];
    $contrasena = $_POST['password'];

    $usuario = userModel::obtenerUsuarioPorCorreo($correo_electronico);

    if ($usuario) {
        // Comparar la contraseña en texto plano (temporalmente)
        if ($contrasena === $usuario['contrasena']) { 
            // Inicio de sesión exitoso
            header('Location: /inicio'); // Redirigir a la página de inicio
            exit;
        } else {
            // Contraseña incorrecta
            echo "Contraseña incorrecta.";
        }
    } else {
        // Usuario no encontrado
        echo "Usuario no encontrado.";
    }
}
?>