<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../includes/conexion.php';
require_once '../includes/clases/clase_habito.php';

try {
    $habito = new Habito($conexion);
    
    if (isset($_GET['id'])) {
        $resultado = $habito->obtenerPorId($_GET['id']);
        if ($resultado) {
            echo json_encode([
                'status' => 'success',
                'data' => $resultado
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Hábito no encontrado'
            ]);
        }
    } else {
        $habitos = $habito->obtenerTodos();
        echo json_encode([
            'status' => 'success',
            'data' => $habitos
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
