<?php
error_reporting(0);
ini_set('display_errors', 0);

header("Access-Control-Allow-Origin: http://127.0.0.1:5501");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

// Manejar preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../includes/clases/clase_habitos.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (!isset($_GET['usuario_id'])) {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'ID de usuario no proporcionado'
        ]);
        exit;
    }

    $usuario_id = filter_var($_GET['usuario_id'], FILTER_SANITIZE_NUMBER_INT);

    try {
        $habitos = new habitos();
        $resultado = $habitos->getHabitosUsuario($usuario_id);
        $habitos_lista = $resultado->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'status' => 'success',
            'data' => $habitos_lista
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
