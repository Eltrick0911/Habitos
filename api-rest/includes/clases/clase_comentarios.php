<?php
require_once("../includes/clases/clase_conexion.php");

class comentarios {
    // Método para obtener todos los comentarios de un grupo
    public static function getComentariosPorGrupo($grupo_id) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('CALL ObtenerComentariosPorGrupo(?)');
        $stmt->execute([$grupo_id]);
        return $stmt;
    }

    // Método para agregar un nuevo comentario
    public static function agregarComentario($grupo_id, $usuario_id, $comentario, $fecha_comentario) {
        try {
            $db = new clase_conexion();
            $con = $db->abrirConexion();
            
            $stmt = $con->prepare('CALL InsertarComentario(?, ?, ?, ?)');
            $stmt->execute([$grupo_id, $usuario_id, $comentario, $fecha_comentario]);

            return $con->lastInsertId();
        } catch (Exception $e) {
            throw new Exception("Error al agregar comentario: " . $e->getMessage());
        }
    }

    // Método para eliminar un comentario
    public function eliminarComentario($id_comentario_habito) {
        try {
            $db = new clase_conexion();
            $con = $db->abrirConexion();
            
            $stmt = $con->prepare('CALL EliminarComentario(?)');
            $stmt->execute([$id_comentario_habito]);
            
            if ($stmt->errorInfo()[0] != '00000') {
                throw new Exception("Error al eliminar el comentario: " . $stmt->errorInfo()[2]);
            }
            
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    // Método para actualizar un comentario
    public static function actualizarComentario($id_comentario_habito, $comentario) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();

        $stmt = $con->prepare('CALL ActualizarComentario(?, ?)');
        $stmt->execute([$id_comentario_habito, $comentario]);

        return $stmt;
    }
}
?> 