<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../includes/clases/clase_comentarios.php";

if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Validar que todos los campos requeridos estén presentes
    $required_fields = ['id_comentario_habito', 'comentario'];

    $missing_fields = array_diff($required_fields, array_keys($data));

    if (empty($missing_fields)) {
        $comentarios = new comentarios();
        
        try {
            $comentarios->actualizarComentario(
                $data['id_comentario_habito'],
                $data['comentario']
            );
            
            header('HTTP/1.1 200 El comentario se actualizó exitosamente!');
            echo json_encode(["message" => "El comentario se actualizó exitosamente!"]);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Error al actualizar el comentario!');
            echo json_encode(["error" => "Error al actualizar el comentario: " . $e->getMessage()]);
        }
    }
} else {
    header('HTTP/1.1 405 Método no permitido!');
    echo json_encode([
        "status" => "error",
        "message" => "Método no permitido!"
    ]);
}
?> 