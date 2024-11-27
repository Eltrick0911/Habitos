<?php
require_once("../includes/clases/clase_conexion.php");

class usuario{
    public static function crear_usuario($nombre, $apellidos, $correo_electronico, $contrasena, $fecha_nacimiento, $genero, $pais_region, $nivel_suscripcion, $preferencias_notificacion) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();

        // Encriptar la contraseña antes de almacenarla
        $contrasena_encriptada = password_hash($contrasena, PASSWORD_DEFAULT);

        $stmt = $con->prepare('CALL InsertarUsuario(?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$nombre, $apellidos, $correo_electronico, $contrasena_encriptada, $fecha_nacimiento, $genero, $pais_region, $nivel_suscripcion, $preferencias_notificacion]);

        return $stmt;
    }

    public static function getusiario($id_Usuario){
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('SELECT * FROM usuario WHERE id_usuario=?');
        $stmt->execute([$id_Usuario]);        
        return ($stmt);       
    }

    public static function existeUsuario($correo_electronico) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('SELECT COUNT(*) FROM Usuario WHERE correo_electronico = ?');
        $stmt->execute([$correo_electronico]);
        
        // Obtener el número de filas
        $count = $stmt->fetchColumn();
        
        return $count > 0;
    }
    
    public static function eliminarUsuario($id_usuario) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('CALL EliminarUsuario(:id_usuario)');
        $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt;
    }
    public static function actualizarUsuario($id_usuario, $nombre, $apellidos, $correo_electronico, $contrasena, $fecha_nacimiento, $genero, $pais_region, $nivel_suscripcion, $preferencias_notificacion) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();

        // Encriptar la contraseña antes de almacenarla
        $contrasena_encriptada = password_hash($contrasena, PASSWORD_DEFAULT);

        $stmt = $con->prepare('CALL ActualizarUsuario(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$id_usuario, $nombre, $apellidos, $correo_electronico, $contrasena_encriptada, $fecha_nacimiento, $genero, $pais_region, $nivel_suscripcion, $preferencias_notificacion]);

        return $stmt;
    }
}
?>