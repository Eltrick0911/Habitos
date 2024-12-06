<?php
// Configurar headers CORS
header("Access-Control-Allow-Origin: http://127.0.0.1:5501");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

// Iniciar sesión antes de cualquier output
session_start();

// Manejar la solicitud OPTIONS (preflight)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../includes/clases/clase_habitos.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        // Verificar si hay un usuario en sesión
        if (!isset($_SESSION['usuario_id'])) {
            http_response_code(401);
            echo json_encode([
                'status' => 'error',
                'message' => 'Usuario no autenticado'
            ]);
            exit;
        }

        // Obtener y decodificar los datos
        $jsonData = file_get_contents("php://input");
        $datos = json_decode($jsonData, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new Exception('Error al decodificar JSON: ' . json_last_error_msg());
        }

        // Crear el hábito y la relación usuario-hábito
        $id_habito = habitos::crear_habito(
            $datos['nombre_habito'],
            $datos['descripcion_habito'],
            $datos['categoria_habito'],
            $datos['objetivo_habito'],
            $datos['frecuencia'],
            $datos['duracion_estimada'],
            $datos['estado'],
            $datos['fecha_inicio'],
            $datos['fecha_estimacion_final'],
            $_SESSION['usuario_id']  // ID del usuario de la sesión
        );

        http_response_code(200);
        echo json_encode([
            'status' => 'success',
            'message' => 'Hábito creado exitosamente',
            'id_habito' => $id_habito
        ]);

    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido'
    ]);
}
?>
