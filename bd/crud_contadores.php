<?php
include_once 'conexion.php';
session_start();

header('Content-Type: application/json');

try {
    $conexion = new Conexion();
    
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
        'success' => true,
        'data' => [
            'usuarios' => (int)$usuarios,
            'habitos' => (int)$habitos,
            'comentarios' => (int)$comentarios
        ]
    ]);
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener contadores: ' . $e->getMessage()
    ]);
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Error inesperado: ' . $e->getMessage()
    ]);
}
?>
