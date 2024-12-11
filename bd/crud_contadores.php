<?php
include_once 'conexion.php';
session_start();

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

header('Content-Type: application/json');

try {
    $conexion = new Conexion();
    echo "Conexión establecida\n";

    // Contar usuarios
    $query = "SELECT COUNT(*) as total FROM usuarios";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $usuarios = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    echo "Usuarios contados: $usuarios\n";

    // Contar hábitos
    $query = "SELECT COUNT(*) as total FROM habitos";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $habitos = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    echo "Hábitos contados: $habitos\n";

    // Contar comentarios
    $query = "SELECT COUNT(*) as total FROM comentarios";
    $stmt = $conexion->prepare($query);
    $stmt->execute();
    $comentarios = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    echo "Comentarios contados: $comentarios\n";

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
