<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../includes/clases/clase_comentarios.php";

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Validar que el campo requerido esté presente
    if (isset($data['id_comentario_habito'])) {
        $comentarios = new comentarios();
        
        try {
            $comentarios->eliminarComentario($data['id_comentario_habito']);
            
            header('HTTP/1.1 200 Comentario eliminado exitosamente!');
            echo json_encode([
                "status" => "success",
                "message" => "El comentario se eliminó exitosamente!"
            ]);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Error al eliminar el comentario!');
            echo json_encode([
                "status" => "error",
                "error" => "Error al eliminar el comentario: " . $e->getMessage()
            ]);
        }
    } else {
        header('HTTP/1.1 400 Falta el ID del comentario!');
        echo json_encode([
            "status" => "error",
            "error" => "Falta el ID del comentario!"
        ]);
    }
} else {
    header('HTTP/1.1 405 Método no permitido!');
    echo json_encode([
        "status" => "error",
        "message" => "Método no permitido!"
    ]);
}
?> 