<?php
require_once("../includes/clases/clase_conexion.php");

class usuario{
    // Método para obtener todos los usuarios
    public static function getTodosUsuarios() {
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('SELECT * FROM usuario');
        $stmt->execute();
        return $stmt;
    }

    public static function getUsuario($id_usuario) {
        try {
            $db = new clase_conexion();
            $con = $db->abrirConexion();
            
            $stmt = $con->prepare("SELECT id_usuario, nombre, apellidos, correo_electronico FROM usuario WHERE id_usuario = ?");
            $stmt->execute([$id_usuario]);
            
            if ($stmt->rowCount() === 0) {
                throw new Exception("Usuario no encontrado");
            }
            
            return $stmt;
        } catch (Exception $e) {
            throw new Exception("Error al obtener usuario: " . $e->getMessage());
        }
    }
    public static function crear_usuario($nombre, $apellidos, $correo_electronico, $contrasena, $fecha_nacimiento, $genero, $pais_region, $nivel_suscripcion, $preferencias_notificacion) {
        try {
            $db = new clase_conexion();
            $con = $db->abrirConexion();
            
            // Iniciar transacción
            $con->beginTransaction();

            // Encriptar la contraseña
            $contrasena_encriptada = password_hash($contrasena, PASSWORD_DEFAULT);

            // Insertar directamente en la tabla usuario primero
            $stmt = $con->prepare('INSERT INTO usuario (nombre, apellidos, correo_electronico, contrasena, fecha_nacimiento, genero, pais_region, nivel_suscripcion, preferencias_notificacion) 
                                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                $nombre, 
                $apellidos, 
                $correo_electronico, 
                $contrasena_encriptada, 
                $fecha_nacimiento, 
                $genero, 
                $pais_region, 
                $nivel_suscripcion, 
                $preferencias_notificacion
            ]);

            // Obtener el ID del usuario recién insertado
            $id_usuario = $con->lastInsertId();

            if (!$id_usuario) {
                throw new Exception("Error al obtener el ID del usuario insertado");
            }

            // Definir el tipo por defecto
            $tipo_default = "usuario";

            // Insertar el tipo de usuario
            $stmt_tipo = $con->prepare('INSERT INTO tipos_usuario (id_usuario, tipo) VALUES (?, ?)');
            $stmt_tipo->execute([$id_usuario, $tipo_default]);

            // Confirmar la transacción
            $con->commit();

            return true;

        } catch (Exception $e) {
            // Si hay error, revertir los cambios
            if ($con->inTransaction()) {
                $con->rollBack();
            }
            throw new Exception("Error al crear usuario: " . $e->getMessage());
        }
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

    public static function validar_login($correo_electronico, $contrasena) {
        try {
            $db = new clase_conexion();
            $con = $db->abrirConexion();

            // Log para debug
            error_log("Intento de login para correo: " . $correo_electronico);

            // Primero obtener el usuario por correo electrónico
            $stmt = $con->prepare("SELECT u.*, t.tipo as tipo_usuario 
                                  FROM usuario u 
                                  JOIN tipos_usuario t ON u.id_usuario = t.id_usuario 
                                  WHERE u.correo_electronico = ?");
            $stmt->execute([$correo_electronico]);
            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$usuario) {
                error_log("Usuario no encontrado para correo: " . $correo_electronico);
                return [
                    'resultado' => 0,
                    'tipo_usuario' => null,
                    'id_usuario' => null,
                    'mensaje' => 'Usuario no encontrado'
                ];
            }

            if (password_verify($contrasena, $usuario['contrasena'])) {
                error_log("Login exitoso para usuario: " . $correo_electronico);
                // Login exitoso
                return [
                    'resultado' => 1,
                    'tipo_usuario' => $usuario['tipo_usuario'],
                    'id_usuario' => $usuario['id_usuario']
                ];
            } else {
                error_log("Contraseña incorrecta para usuario: " . $correo_electronico);
                return [
                    'resultado' => 0,
                    'tipo_usuario' => null,
                    'id_usuario' => null,
                    'mensaje' => 'Contraseña incorrecta'
                ];
            }
        } catch (PDOException $e) {
            error_log("Error en BD durante login: " . $e->getMessage());
            throw new Exception("Error al validar login: " . $e->getMessage());
        }
    }

    public function obtener_datos_usuario($id_usuario) {
        try {
            $db = new clase_conexion();
            $con = $db->abrirConexion();
            
            $query = "SELECT nombre, apellidos FROM usuarios WHERE id_usuario = :id_usuario";
            $stmt = $con->prepare($query);
            $stmt->bindParam(':id_usuario', $id_usuario, PDO::PARAM_INT);
            $stmt->execute();
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener datos del usuario: " . $e->getMessage());
        }
    }
}
?>