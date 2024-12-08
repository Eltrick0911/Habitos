<?php
header("Access-Control-Allow-Origin: http://127.0.0.1:5501");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, PUT, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

// Manejar preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../includes/clases/clase_habitos.php";
require_once "../../vendor/autoload.php";
require_once "../../src/config/Security.php";

// Validar el token JWT
try {
    // Obtener el token del header
    $headers = getallheaders();
    $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';
    
    if (empty($authHeader)) {
        throw new Exception('Token no proporcionado');
    }

    // Extraer el token del header Bearer
    list($bearer, $token) = explode(' ', $authHeader);
    if (empty($token)) {
        throw new Exception('Token vacío');
    }

    // Validar el token
    $security = new \App\config\Security();
    $decoded = $security->validateTokenJwt($token);
    
    // Obtener los datos de la petición
    $data = json_decode(file_get_contents("php://input"), true);
    
    // Verificar que el usuario del token coincida con el usuario que hace la petición
    if (!isset($data['usuario_id']) || $decoded->data->id != $data['usuario_id']) {
        throw new Exception('Usuario no autorizado para esta operación');
    }

} catch (Exception $e) {
    http_response_code(401);
    echo json_encode([
        "status" => "error",
        "message" => "Error de autenticación: " . $e->getMessage()
    ]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Validar que todos los campos requeridos estén presentes
    $required_fields = [
        'id_habito', 'nombre_habito', 'descripcion_habito', 'categoria_habito', 
        'objetivo_habito', 'frecuencia', 'duracion_estimada', 
        'estado', 'fecha_inicio', 'fecha_estimacion_final'
    ];

    $missing_fields = array_diff($required_fields, array_keys($data));

    if (empty($missing_fields)) {
        // Validar el enum de frecuencia
        $frecuencias_validas = ['diaria', 'semanal', 'mensual', 'personalizada'];
        if (!in_array($data['frecuencia'], $frecuencias_validas)) {
            header('HTTP/1.1 400 Frecuencia no válida!');
            echo json_encode(["error" => "La frecuencia debe ser: diaria, semanal, mensual o personalizada"]);
            exit;
        }

        // Validar el enum de estado
        $estados_validos = ['activo', 'pausado', 'completado'];
        if (!in_array($data['estado'], $estados_validos)) {
            header('HTTP/1.1 400 Estado no válido!');
            echo json_encode(["error" => "El estado debe ser: activo, pausado o completado"]);
            exit;
        }

        $habitos = new habitos();
        
        try {
            $habitos->actualizarHabito(
                $data['id_habito'],
                $data['nombre_habito'],
                $data['descripcion_habito'],
                $data['categoria_habito'],
                $data['objetivo_habito'],
                $data['frecuencia'],
                $data['duracion_estimada'],
                $data['estado'],
                $data['fecha_inicio'],
                $data['fecha_estimacion_final']
            );
            
            echo json_encode([
                "status" => "success",
                "message" => "El hábito se actualizó exitosamente!"
            ]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                "status" => "error",
                "message" => "Error al actualizar el hábito: " . $e->getMessage()
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
