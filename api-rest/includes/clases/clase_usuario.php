<?php
require_once("../includes/clases/clase_conexion.php");

class Usuario{
    public static function crear_Usuario($id_usuario,$nombre,$apellido,$coreo,$contraseña,$F_nacimiemto,$genero,$P_region,$P_suscripcion,$P_notificacion){
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('InsertarUsuario');
        $stmt->execute([NULL,$nombre,$apellido,$coreo,$contraseña,$F_nacimiemto,$genero,$P_region,$P_suscripcion,$P_notificacion]);
        return ($stmt);
    }


    public static function getUsuario($id_Usuario){
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('SELECT * FROM usuario WHERE id_Usuario=?');
        $stmt->execute([$id_Usuario]);        
        return ($stmt);       
    }

    
     public static function eliminarUsuario($id_usuario){
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('EliminarUsuario');
        $stmt->bindParam(':id_usuario', $id_usuario);
        $stmt->execute();        
        return ($stmt);       
    }

    public static function actualizar_abogado($id_usuario,$nombre,$apellido,$coreo,$contraseña,$F_nacimiemto,$genero,$P_region,$P_suscripcion,$P_notificacion){
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('UPDATE tbl_abogados SET dni=?, nombre=?, apellidos=?, direccion=?, telefono=?, id_gabinete=? WHERE id_abogado=?');
         $stmt->execute([$id_usuario,$nombre,$apellido,$coreo,$contraseña,$F_nacimiemto,$genero,$P_region,$P_suscripcion,$P_notificacion]);
        return ($stmt);
    }
}
?>