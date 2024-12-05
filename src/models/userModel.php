<?php
namespace App\models;

use App\db\connectionDB;
use App\db\sql;
use App\config\responseHTTP;

class userModel extends connectionDB {
    private static $nombre;
    private static $apellidos;
    private static $correo_electronico;
    private static $contrasena;
    private static $fecha_nacimiento;
    private static $genero;
    private static $pais_region;
    private static $nivel_suscripcion;
    private static $preferencias_notificacion;
    private static $IDToken;
    private static $fecha;

    // Constructor
    public function __construct(array $data) {
        self::$nombre = $data['nombre'];
        self::$apellidos = $data['apellidos'];
        self::$correo_electronico = $data['correo_electronico'];
        self::$contrasena = $data['contrasena'];
        self::$fecha_nacimiento = $data['fecha_nacimiento'];
        self::$genero = $data['genero'];
        self::$pais_region = $data['pais_region'];
        self::$nivel_suscripcion = $data['nivel_suscripcion'];
        self::$preferencias_notificacion = $data['preferencias_notificacion'];
        self::$IDToken = $data['IDToken'];
        self::$fecha = $data['fecha'];
    }

    // Métodos gets
    final public static function getNombre() { return self::$nombre; }
    final public static function getApellidos() { return self::$apellidos; }
    final public static function getCorreoElectronico() { return self::$correo_electronico; }
    final public static function getContrasena() { return self::$contrasena; }
    final public static function getFechaNacimiento() { return self::$fecha_nacimiento; }
    final public static function getGenero() { return self::$genero; }
    final public static function getPaisRegion() { return self::$pais_region; }
    final public static function getNivelSuscripcion() { return self::$nivel_suscripcion; }
    final public static function getPreferenciasNotificacion() { return self::$preferencias_notificacion; }
    final public static function getIDToken() { return self::$IDToken; }
    final public static function getFecha() { return self::$fecha; }

    // Métodos sets
    final public static function setNombre($nombre) { self::$nombre = $nombre; }
    final public static function setApellidos($apellidos) { self::$apellidos = $apellidos; }
    final public static function setCorreoElectronico($correo_electronico) { self::$correo_electronico = $correo_electronico; }
    final public static function setContrasena($contrasena) { self::$contrasena = $contrasena; }
    final public static function setFechaNacimiento($fecha_nacimiento) { self::$fecha_nacimiento = $fecha_nacimiento; }
    final public static function setGenero($genero) { self::$genero = $genero; }
    final public static function setPaisRegion($pais_region) { self::$pais_region = $pais_region; }
    final public static function setNivelSuscripcion($nivel_suscripcion) { self::$nivel_suscripcion = $nivel_suscripcion; }
    final public static function setPreferenciasNotificacion($preferencias_notificacion) { self::$preferencias_notificacion = $preferencias_notificacion; }
    final public static function setIDToken($IDToken) { self::$IDToken = $IDToken; }
    final public static function setFecha($fecha) { self::$fecha = $fecha; }

    final public static function post() {
        // Validamos que el registro no se encuentre registrado en nuestra BD por correo electrónico
        if (sql::verificarRegistro('SELECT correo_electronico FROM Usuario WHERE correo_electronico = :correo_electronico', ':correo_electronico', self::getCorreoElectronico())) {
            return responseHTTP::status400('El correo electrónico está registrado en la BD');
        } else {
            // Si no está registrado, procedemos a insertar el registro
            self::setIDToken(hash('sha512', self::getCorreoElectronico())); // Nos permitirá registrar, actualizar o eliminar el usuario
            self::setFecha(date("Y-m-d H:i:s")); // Fecha de creación

            try {
                $con = self::getConnection();
                $query = "CALL InsertarUsuario(:nombre, :apellidos, :correo_electronico, :contrasena, :fecha_nacimiento, :genero, :pais_region, :nivel_suscripcion, :preferencias_notificacion)";
                $stmt = $con->prepare($query);
                $stmt->execute([
                    ':nombre' => self::getNombre(),
                    ':apellidos' => self::getApellidos(),
                    ':correo_electronico' => self::getCorreoElectronico(),
                    ':contrasena' => password_hash(self::getContrasena(), PASSWORD_DEFAULT), // Encriptar la contraseña
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
                error_log('userModel::post -> ' . $e);
                die(json_encode(responseHTTP::status500()));
            }
        }
    }
    final public static function getUsuarioPorCorreo($correo_electronico) {
        $con = self::getConnection();
        $stmt = $con->prepare('SELECT * FROM Usuario WHERE correo_electronico = :correo_electronico');
        $stmt->bindParam(':correo_electronico', $correo_electronico);
        $stmt->execute();

        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    final public static function validarLogin($correo_electronico, $contrasena) {
        $con = self::getConnection();
        $stmt = $con->prepare('CALL validar_login(:correo_electronico, :contrasena, @resultado)');
        $stmt->bindParam(':correo_electronico', $correo_electronico);
        $stmt->bindParam(':contrasena', $contrasena);
        $stmt->execute();

        $stmt = $con->query('SELECT @resultado AS resultado');
        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $resultado['resultado'] == 1;
    }
}

