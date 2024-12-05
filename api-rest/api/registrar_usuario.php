<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Headers CORS
header("Access-Control-Allow-Origin: http://127.0.0.1:5501");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        require_once "../includes/clases/clase_usuario.php";
        
        $input = file_get_contents("php://input");
        $data = json_decode($input, true);
        
        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception("Error decodificando JSON: " . json_last_error_msg());
        }

        // Crear el usuario usando la clase usuario
        $resultado = usuario::crear_usuario(
            $data['nombre'],
            $data['apellidos'],
            $data['correo_electronico'],
            $data['contrasena'],
            $data['fecha_nacimiento'],
            $data['genero'],
            $data['pais_region'],
            $data['nivel_suscripcion'],
            $data['preferencias_notificacion']
        );

        if ($resultado) {
            echo json_encode([
                "message" => "Usuario registrado exitosamente",
                "status" => "success"
            ]);
        } else {
            throw new Exception("Error al registrar el usuario");
        }

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            "error" => $e->getMessage(),
            "status" => "error"
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode(["error" => "Método no permitido"]);
}
?>
