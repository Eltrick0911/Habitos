<?php
header("Access-Control-Allow-Origin: http://127.0.0.1:5501");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

// Manejar preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../includes/clases/clase_comentarios.php";
require_once "../../src/config/Security.php";

// Validar el token JWT
$security = new \App\config\Security();
try {
    $security->validateTokenJwt($security->secretKey());
} catch (Exception $e) {
    http_response_code(401);
    echo json_encode([
        "status" => "error",
        "message" => "Token inválido o expirado"
    ]);
    exit;
}

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
} else {
    http_response_code(405);
    echo json_encode([
        "status" => "error",
        "message" => "Método no permitido!"
    ]);
}
?> 