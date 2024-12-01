<?php
require 'path/to/clase_conexion.php'; // Ajusta la ruta según tu estructura de carpetas

class Usuario {
    public static function eliminarUsuario($id_usuario) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('CALL EliminarUsuario(:id_usuario)');
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }
}

// Ejemplo de uso
$id_usuario = 1; // ID del usuario que deseas eliminar
$resultado = Usuario::eliminarUsuario($id_usuario);

if ($resultado) {
    echo "Usuario eliminado exitosamente.";
} else {
    echo "Error al eliminar el usuario.";
}