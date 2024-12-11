<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

require_once '../includes/conexion.php';

try {
    // Contar usuarios
    $query = "SELECT COUNT(*) as total FROM usuarios";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $usuarios = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Contar hábitos
    $query = "SELECT COUNT(*) as total FROM habitos";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $habitos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Contar comentarios
    $query = "SELECT COUNT(*) as total FROM comentarios";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $comentarios = $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    echo json_encode([
        'status' => 'success',
        'data' => [
            'usuarios' => (int)$usuarios,
            'habitos' => (int)$habitos,
            'comentarios' => (int)$comentarios
        ]
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
?>
