<?php
namespace App\models;

use App\db\connectionDB;
use App\db\sql;
use App\config\responseHTTP;

class userModel extends connectionDB {
    private static $id_usuario; // Agregamos el ID para la modificación
    private static $nombre;
    private static $apellidos;
    private static $correo_electronico;
    private static $contrasena;
    private static $fecha_nacimiento;
    private static $genero;
    private static $pais_region;
    private static $nivel_suscripcion;
    private static $preferencias_notificacion;


    //constructor
    public function __construct(array $data) {
        // Asignamos las propiedades solo si existen en el array $data
        if (isset($data['id_usuario'])) self::$id_usuario = $data['id_usuario'];
        if (isset($data['nombre'])) self::$nombre = $data['nombre'];
        if (isset($data['apellidos'])) self::$apellidos = $data['apellidos'];
        if (isset($data['correo_electronico'])) self::$correo_electronico = $data['correo_electronico'];
        if (isset($data['contrasena'])) self::$contrasena = $data['contrasena'];
        if (isset($data['fecha_nacimiento'])) self::$fecha_nacimiento = $data['fecha_nacimiento'];
        if (isset($data['genero'])) self::$genero = $data['genero'];
        if (isset($data['pais_region'])) self::$pais_region = $data['pais_region'];
        if (isset($data['nivel_suscripcion'])) self::$nivel_suscripcion = $data['nivel_suscripcion'];
        if (isset($data['preferencias_notificacion'])) self::$preferencias_notificacion = $data['preferencias_notificacion'];
    }

    // Métodos gets
    final public static function getIdUsuario() { return self::$id_usuario; }
    final public static function getNombre() { return self::$nombre; }
    final public static function getApellidos() { return self::$apellidos; }
    final public static function getCorreoElectronico() { return self::$correo_electronico; }
    final public static function getContrasena() { return self::$contrasena; }
    final public static function getFechaNacimiento() { return self::$fecha_nacimiento; }
    final public static function getGenero() { return self::$genero; }
    final public static function getPaisRegion() { return self::$pais_region; }
    final public static function getNivelSuscripcion() { return self::$nivel_suscripcion; }
    final public static function getPreferenciasNotificacion() { return self::$preferencias_notificacion; }
 
    // Métodos sets
    final public static function setIdUsuario($id_usuario) { self::$id_usuario = $id_usuario; }
    final public static function setNombre($nombre) { self::$nombre = $nombre; }
    final public static function setApellidos($apellidos) { self::$apellidos = $apellidos; }
    final public static function setCorreoElectronico($correo_electronico) { self::$correo_electronico = $correo_electronico; }
    final public static function setContrasena($contrasena) { self::$contrasena = $contrasena; }
    final public static function setFechaNacimiento($fecha_nacimiento) { self::$fecha_nacimiento = $fecha_nacimiento; }
    final public static function setGenero($genero) { self::$genero = $genero; }
    final public static function setPaisRegion($pais_region) { self::$pais_region = $pais_region; }
    final public static function setNivelSuscripcion($nivel_suscripcion) { self::$nivel_suscripcion = $nivel_suscripcion; }
    final public static function setPreferenciasNotificacion($preferencias_notificacion) { self::$preferencias_notificacion = $preferencias_notificacion; }

    // Método para crear un nuevo usuario
    final public static function crearUsuario() {
        try {
            $con = self::getConnection();
            $stmt = $con->prepare("CALL InsertarUsuario(:nombre, :apellidos, :correo_electronico, :contrasena, :fecha_nacimiento, :genero, :pais_region, :nivel_suscripcion, :preferencias_notificacion)");
            $stmt->execute([
                ':nombre' => self::getNombre(),
                ':apellidos' => self::getApellidos(),
                ':correo_electronico' => self::getCorreoElectronico(),
                ':contrasena' => self::getContrasena(),
                ':fecha_nacimiento' => self::getFechaNacimiento(),
                ':genero' => self::getGenero(),
                ':pais_region' => self::getPaisRegion(),
                ':nivel_suscripcion' => self::getNivelSuscripcion(),
                ':preferencias_notificacion' => self::getPreferenciasNotificacion()
            ]);
            
            if ($stmt->rowCount() > 0) {
                return responseHTTP::status200('Se ha registrado el usuario exitosamente!!!');
            } else {
                return responseHTTP::status500('Error al registrar el usuario!!!');
            }

        } catch (\PDOException $e) {
            error_log('userModel::crearUsuario -> ' . $e);
            return responseHTTP::status500();
        }
    }

    // Método para modificar un usuario existente
    // Método para modificar un usuario existente
    final public static function modificarUsuario() {
        try {
            $con = self::getConnection();
            $stmt = $con->prepare("CALL ActualizarUsuario(:id_usuario, :nombre, :apellidos, :correo_electronico, :contrasena, :fecha_nacimiento, :genero, :pais_region, :nivel_suscripcion, :preferencias_notificacion)");
            $stmt->execute([
                ':id_usuario' => self::getIdUsuario(),
                ':nombre' => self::getNombre(),
                ':apellidos' => self::getApellidos(),
                ':correo_electronico' => self::getCorreoElectronico(),
                ':contrasena' => self::getContrasena(),
                ':fecha_nacimiento' => self::getFechaNacimiento(),
                ':genero' => self::getGenero(),
                ':pais_region' => self::getPaisRegion(),
                ':nivel_suscripcion' => self::getNivelSuscripcion(),
                ':preferencias_notificacion' => self::getPreferenciasNotificacion()
            ]);
            
            if ($stmt->rowCount() > 0) {
                return responseHTTP::status200('Se ha modificado el usuario exitosamente!!!');
            } else {
                return responseHTTP::status500('Error al modificar el usuario!!!');
            }

        } catch (\PDOException $e) {
            error_log('userModel::modificarUsuario -> ' . $e);
            return responseHTTP::status500();
        }
    }
    // Método para obtener un usuario por su ID
    final public static function obtenerUsuarioPorId($id_usuario) {
        try {
            $con = self::getConnection();
            $query = "SELECT * FROM Usuario WHERE id_usuario = :id_usuario";
            $stmt = $con->prepare($query);
            $stmt->execute([':id_usuario' => $id_usuario]);

            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(\PDO::FETCH_ASSOC); // Retorna la información del usuario
            } else {
                return null; // Retorna null si no se encuentra el usuario
            }
        } catch (\PDOException $e) {
            error_log('userModel::obtenerUsuarioPorId -> ' . $e);
            return null;
        }
    }
    final public static function obtenerUsuarioPorCorreo($correo_electronico) {
        try {
            $con = self::getConnection();
            $query = "SELECT * FROM Usuario WHERE correo_electronico = :correo_electronico";
            $stmt = $con->prepare($query);
            $stmt->execute([':correo_electronico' => $correo_electronico]);
    
            if ($stmt->rowCount() > 0) {
                return $stmt->fetch(\PDO::FETCH_ASSOC); 
            } else {
                return null; 
            }
        } catch (\PDOException $e) {
            error_log('userModel::obtenerUsuarioPorCorreo -> ' . $e);
            return null;
        }
    }

    // Método para eliminar un usuario
    final public static function eliminarUsuario($id_usuario) {
        try {
            $con = self::getConnection();
            $stmt = $con->prepare("CALL EliminarUsuario(:id_usuario)"); // Llamada al procedimiento almacenado
            $stmt->execute([':id_usuario' => $id_usuario]);
    
            if ($stmt->rowCount() > 0) {
                return responseHTTP::status200('Se ha eliminado el usuario exitosamente!!!');
            } else {
                return responseHTTP::status500('Error al eliminar el usuario!!!');
            }
    
        } catch (\PDOException $e) {
            error_log('userModel::eliminarUsuario -> ' . $e);
            return responseHTTP::status500();
        }
    }
}