<?php
require_once "../includes/clases/clase_conexion.php";

try {
    $db = new clase_conexion();
    $con = $db->abrirConexion();
    
    // La nueva contraseña que queremos establecer
    $nueva_contrasena = "password123"; // Puedes cambiar esto por la contraseña que desees
    $email = "juan.perez@example.com";
    
    // Encriptar la nueva contraseña
    $contrasena_encriptada = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
    
    // Actualizar la contraseña
    $stmt = $con->prepare("UPDATE usuario SET contrasena = ? WHERE correo_electronico = ?");
    $resultado = $stmt->execute([$contrasena_encriptada, $email]);
    
    if ($resultado) {
        echo "Contraseña actualizada exitosamente.\n";
        echo "Email: " . $email . "\n";
        echo "Nueva contraseña: " . $nueva_contrasena . "\n";
    } else {
        echo "No se pudo actualizar la contraseña.\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
