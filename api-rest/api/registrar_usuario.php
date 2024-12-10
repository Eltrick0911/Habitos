<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Obtener el origen de la solicitud
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

// Permitir solo orígenes de localhost con cualquier puerto
if (preg_match('/^http:\/\/localhost(:[0-9]+)?$/', $origin)) {
    header("Access-Control-Allow-Origin: " . $origin);
}

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

        error_log("Datos recibidos: " . print_r($data, true));

        $campos_requeridos = ['nombre', 'apellidos', 'correo_electronico', 'contrasena', 
                            'fecha_nacimiento', 'genero', 'pais_region', 
                            'nivel_suscripcion', 'preferencias_notificacion'];
        
        foreach ($campos_requeridos as $campo) {
            if (!isset($data[$campo])) {
                throw new Exception("Campo requerido faltante: " . $campo);
            }
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
            http_response_code(200);
            echo json_encode([
                "message" => "Usuario registrado exitosamente",
                "status" => "success"
            ]);
        } else {
            throw new Exception("Error al registrar el usuario");
        }

    } catch (Exception $e) {
        error_log("Error en registro: " . $e->getMessage());
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
