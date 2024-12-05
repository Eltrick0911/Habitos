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
                                      $estado, $fecha_inicio, $fecha_estimacion_final) {
        $db = new clase_conexion();
        $con = $db->abrirConexion();

        $stmt = $con->prepare('CALL InsertarHabito(?, ?, ?, ?, ?, ?, ?, ?, ?)');
        
        $stmt->execute([$nombre_habito, $descripcion_habito, $categoria_habito, 
                       $objetivo_habito, $frecuencia, $duracion_estimada, 
                       $estado, $fecha_inicio, $fecha_estimacion_final]);

        return $stmt;
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
        
        $stmt->execute([$id_habito, $nombre_habito, $descripcion_habito, $categoria_habito, 
                       $objetivo_habito, $frecuencia, $duracion_estimada, 
                       $estado, $fecha_inicio, $fecha_estimacion_final]);

        return $stmt;
    }

    // Método para obtener hábitos por estado
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
}
?>
