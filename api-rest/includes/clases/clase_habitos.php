<?php
require_once("../includes/clases/clase_conexion.php");

class habitos {
    // Método para obtener todos los hábitos
    public static function getTodosHabitos() {
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('CALL ObtenerTodosHabitos()');
        $stmt->execute();
        return $stmt;
    }

    // Método para obtener un hábito específico
    public static function getHabito($id_habito) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('CALL ObtenerHabito(?)');
        $stmt->execute([$id_habito]);        
        return $stmt;       
    }

    // Método para crear un nuevo hábito
    public static function crear_habito($nombre_habito, $descripcion_habito, $categoria_habito, 
                                      $objetivo_habito, $frecuencia, $duracion_estimada, 
                                      $estado, $fecha_inicio, $fecha_estimacion_final, $usuario_id) {
        try {
            $db = new clase_conexion();
            $con = $db->abrirConexion();
            
            // Llamar al procedimiento almacenado
            $stmt = $con->prepare('CALL InsertarHabito(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @id_habito)');
            $stmt->execute([
                $nombre_habito, 
                $descripcion_habito, 
                $categoria_habito,
                $objetivo_habito, 
                $frecuencia, 
                $duracion_estimada,
                $estado, 
                $fecha_inicio, 
                $fecha_estimacion_final,
                $usuario_id
            ]);

            // Obtener el ID del hábito insertado
            $result = $con->query("SELECT @id_habito as id_habito")->fetch();
            return $result['id_habito'];

        } catch (Exception $e) {
            throw new Exception("Error al crear hábito: " . $e->getMessage());
        }
    }

    // Método para eliminar un hábito
    public function eliminarHabito($id_habito) {
        try {
            $db = new clase_conexion();
            $con = $db->abrirConexion();
            
            // Primero eliminamos las relaciones en usuario_habito
            $this->eliminarUsuarioHabito($id_habito);
            
            // Luego eliminamos el hábito usando el procedimiento almacenado
            $stmt = $con->prepare('CALL EliminarHabito(?)');
            $stmt->execute([$id_habito]);
            
            if ($stmt->errorInfo()[0] != '00000') {
                throw new Exception("Error al eliminar el hábito: " . $stmt->errorInfo()[2]);
            }
            
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    // Método para actualizar un hábito
    public static function actualizarHabito($id_habito, $nombre_habito, $descripcion_habito, 
                                          $categoria_habito, $objetivo_habito, $frecuencia, 
                                          $duracion_estimada, $estado, $fecha_inicio, 
                                          $fecha_estimacion_final) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();

        $stmt = $con->prepare('CALL ActualizarHabito(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        
        $stmt->execute([$id_habito, $nombre_habito, $descripcion_habito, $categoria_habito, 
                       $objetivo_habito, $frecuencia, $duracion_estimada, 
                       $estado, $fecha_inicio, $fecha_estimacion_final]);

        return $stmt;
    }

    // Método para obtener hbitos por estado
    public static function getHabitosPorEstado($estado) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('CALL ObtenerHabitosPorEstado(?)');
        $stmt->execute([$estado]);
        return $stmt;
    }

    // Método para obtener hábitos por categoría
    public static function getHabitosPorCategoria($categoria) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('CALL ObtenerHabitosPorCategoria(?)');
        $stmt->execute([$categoria]);
        return $stmt;
    }

    // Método para obtener hábitos de un usuario
    public static function getHabitosUsuario($usuario_id) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('SELECT h.* FROM Habito h 
                              INNER JOIN usuario_habito uh ON h.id_habito = uh.habito_id 
                              WHERE uh.usuario_id = ?');
        $stmt->execute([$usuario_id]);
        return $stmt;
    }

    public function eliminarUsuarioHabito($id_habito) {
        try {
            $db = new clase_conexion();
            $con = $db->abrirConexion();
            
            $stmt = $con->prepare('DELETE FROM usuario_habito WHERE habito_id = ?');
            $stmt->execute([$id_habito]);
            
            if ($stmt->errorInfo()[0] != '00000') {
                throw new Exception("Error al eliminar la relación usuario-hábito: " . $stmt->errorInfo()[2]);
            }
            
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }
}
?>
