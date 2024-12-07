<?php
require_once("../includes/clases/clase_conexion.php");

class grupo_apoyo {
    // Método para obtener todos los grupos de apoyo
    public static function getTodosGrupos() {
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('SELECT * FROM grupo_apoyo');
        $stmt->execute();
        return $stmt;
    }

    // Método para obtener un grupo de apoyo específico
    public static function getGrupo($id_grupo) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('SELECT * FROM grupo_apoyo WHERE id_grupo = ?');
        $stmt->execute([$id_grupo]);
        return $stmt;
    }

    // Método para crear un nuevo grupo de apoyo
    public static function crearGrupo($nombre_grupo, $tipo_habito) {
        try {
            $db = new clase_conexion();
            $con = $db->abrirConexion();
            
            $stmt = $con->prepare('INSERT INTO grupo_apoyo (nombre_grupo, tipo_habito) VALUES (?, ?)');
            $stmt->execute([$nombre_grupo, $tipo_habito]);

            return $con->lastInsertId();
        } catch (Exception $e) {
            throw new Exception("Error al crear grupo de apoyo: " . $e->getMessage());
        }
    }

    // Método para eliminar un grupo de apoyo
    public function eliminarGrupo($id_grupo) {
        try {
            $db = new clase_conexion();
            $con = $db->abrirConexion();
            
            $stmt = $con->prepare('DELETE FROM grupo_apoyo WHERE id_grupo = ?');
            $stmt->execute([$id_grupo]);
            
            if ($stmt->errorInfo()[0] != '00000') {
                throw new Exception("Error al eliminar el grupo de apoyo: " . $stmt->errorInfo()[2]);
            }
            
            return true;
        } catch (Exception $e) {
            throw $e;
        }
    }

    // Método para actualizar un grupo de apoyo
    public static function actualizarGrupo($id_grupo, $nombre_grupo, $tipo_habito) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();

        $stmt = $con->prepare('UPDATE grupo_apoyo SET nombre_grupo = ?, tipo_habito = ? WHERE id_grupo = ?');
        $stmt->execute([$nombre_grupo, $tipo_habito, $id_grupo]);

        return $stmt;
    }

    // Método para obtener grupos por tipo de hábito
    public static function getGruposPorTipoHabito($tipo_habito) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();
        $stmt = $con->prepare('SELECT * FROM grupo_apoyo WHERE tipo_habito = ?');
        $stmt->execute([$tipo_habito]);
        return $stmt;
    }
}
?> 