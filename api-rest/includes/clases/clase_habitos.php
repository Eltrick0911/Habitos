<?php
require_once("../includes/clases/clase_conexion.php");

class habitos {
    // Método para obtener todos los hábitos
    public static function getTodosHabitos() {
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('SELECT * FROM Habito');
        $stmt->execute();
        return $stmt;
    }

    // Método para obtener un hábito específico
    public static function getHabito($id_habito) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('SELECT * FROM Habito WHERE id_habito = ?');
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
            
            // Iniciamos la transacción
            $con->beginTransaction();

            // Primero insertamos el hábito
            $stmt = $con->prepare('CALL InsertarHabito(?, ?, ?, ?, ?, ?, ?, ?, ?)');
            $stmt->execute([
                $nombre_habito, 
                $descripcion_habito, 
                $categoria_habito,
                $objetivo_habito, 
                $frecuencia, 
                $duracion_estimada,
                $estado, 
                $fecha_inicio, 
                $fecha_estimacion_final
            ]);

            // Obtenemos el ID del hábito recién insertado
            $id_habito = $con->lastInsertId();

            // Insertamos la relación usuario-hábito
            $stmt_relacion = $con->prepare('
                INSERT INTO usuario_habito (usuario_id, habito_id) 
                VALUES (?, ?)
            ');
            $stmt_relacion->execute([$usuario_id, $id_habito]);

            // Confirmamos la transacción
            $con->commit();

            return $id_habito;

        } catch (Exception $e) {
            // Si hay error, revertimos los cambios
            $con->rollBack();
            throw new Exception("Error al crear hábito: " . $e->getMessage());
        }
    }

    // Método para eliminar un hábito
    public static function eliminarHabito($id_habito) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('CALL EliminarHabito(?)');
        $stmt->execute([$id_habito]);
        return $stmt;
    }

    // Método para actualizar un hábito
    public static function actualizarHabito($id_habito, $nombre_habito, $descripcion_habito, 
                                          $categoria_habito, $objetivo_habito, $frecuencia, 
                                          $duracion_estimada, $estado, $fecha_inicio, 
                                          $fecha_estimacion_final) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();

        $stmt = $con->prepare('CALL ActualizarHabito(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        
        $stmt->execute([
            $id_habito,
            $nombre_habito, 
            $descripcion_habito, 
            $categoria_habito,
            $objetivo_habito, 
            $frecuencia, 
            $duracion_estimada,
            $estado, 
            $fecha_inicio, 
            $fecha_estimacion_final
        ]);

        return $stmt;
    }

    // Método para obtener hbitos por estado
    public static function getHabitosPorEstado($estado) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('SELECT * FROM Habito WHERE estado = ?');
        $stmt->execute([$estado]);
        return $stmt;
    }

    // Método para obtener hábitos por categoría
    public static function getHabitosPorCategoria($categoria) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('SELECT * FROM Habito WHERE categoria_habito = ?');
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
}
