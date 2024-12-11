<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../includes/conexion.php';
require_once '../includes/clases/clase_comentario.php';

try {
    $comentario = new Comentario($conexion);
    
    if (isset($_GET['id'])) {
        $resultado = $comentario->obtenerPorId($_GET['id']);
        if ($resultado) {
            echo json_encode([
                'status' => 'success',
                'data' => $resultado
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Comentario no encontrado'
            ]);
        }
    } else {
        $comentarios = $comentario->obtenerTodos();
        echo json_encode([
            'status' => 'success',
            'data' => $comentarios
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
