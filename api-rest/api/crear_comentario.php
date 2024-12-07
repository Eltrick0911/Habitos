<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../includes/clases/clase_comentarios.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Validar que todos los campos requeridos estén presentes
    $required_fields = ['grupo_id', 'usuario_id', 'comentario', 'fecha_comentario'];

    $missing_fields = array_diff($required_fields, array_keys($data));

    if (empty($missing_fields)) {
        $comentarios = new comentarios();
        
        try {
            $comentarios->agregarComentario(
                $data['grupo_id'],
                $data['usuario_id'],
                $data['comentario'],
                $data['fecha_comentario']
            );
            
            header('HTTP/1.1 201 Comentario creado exitosamente!');
            echo json_encode(["message" => "Comentario creado exitosamente!"]);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Error al crear el comentario!');
            echo json_encode(["error" => "Error al crear el comentario: " . $e->getMessage()]);
        }
    } else {
        header('HTTP/1.1 400 Faltan campos requeridos!');
        echo json_encode([
            "error" => "Faltan campos requeridos",
            "campos_faltantes" => array_values($missing_fields)
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