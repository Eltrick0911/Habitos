<?php
header("Access-Control-Allow-Origin: http://127.0.0.1:5501");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Manejar preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../includes/clases/clase_comentarios.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
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
                
                echo json_encode([
                    "status" => "success",
                    "message" => "Comentario creado exitosamente!"
                ]);
            } catch (Exception $e) {
                http_response_code(500);
                echo json_encode([
                    "status" => "error",
                    "message" => "Error al crear el comentario: " . $e->getMessage()
                ]);
            }
        } else {
            http_response_code(400);
            echo json_encode([
                "status" => "error",
                "message" => "Faltan campos requeridos",
                "campos_faltantes" => array_values($missing_fields)
            ]);
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            "status" => "error",
            "message" => "Error inesperado: " . $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Método no permitido!"
    ]);
}
?> 