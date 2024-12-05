<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once "../includes/clases/clase_habitos.php";
require_once "../includes/middleware/AuthMiddleware.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    session_start();
    
    // Verificar si hay un usuario en sesión
    if (!isset($_SESSION['usuario_id'])) {
        header('HTTP/1.1 401 No autorizado!');
        echo json_encode([
            'status' => 'error',
            'message' => 'Usuario no autenticado'
        ]);
        exit;
    }

    $habitos = new habitos();
    
    // Obtener los hábitos del usuario en sesión
    $resultado = $habitos->getHabitosUsuario($_SESSION['usuario_id']);
    $habitos_lista = $resultado->fetchAll(PDO::FETCH_ASSOC);
    
    header('HTTP/1.1 200 OK');
    echo json_encode([
        'status' => 'success',
        'data' => $habitos_lista
    ]);
} else {
    header('HTTP/1.1 405 Método no permitido!');
    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido!'
    ]);
}
?>
