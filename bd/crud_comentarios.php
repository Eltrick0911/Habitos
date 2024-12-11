<?php
include_once 'conexion.php';
session_start();

$operacion = isset($_GET['operacion']) ? $_GET['operacion'] : 'consultar';
$conexion = new Conexion();
$data = json_decode(file_get_contents('php://input'), true);

switch($operacion) {
    case 'consultar':
        $query = "SELECT c.*, u.nombre as usuario, h.titulo as habito 
                 FROM comentarios c
                 LEFT JOIN usuarios u ON c.id_usuario = u.id
                 LEFT JOIN habitos h ON c.id_habito = h.id";
        $stmt = $conexion->prepare($query);
        $stmt->execute();
        $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode(['success' => true, 'data' => $resultado]);
        break;

    case 'crear':
        if (!isset($data['comentario']) || !isset($data['id_usuario']) || !isset($data['id_habito'])) {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
            exit;
        }
        
        $query = "INSERT INTO comentarios (comentario, id_usuario, id_habito) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($query);
        
        try {
            $stmt->execute([$data['comentario'], $data['id_usuario'], $data['id_habito']]);
            echo json_encode(['success' => true, 'message' => 'Comentario creado correctamente']);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error al crear comentario']);
        }
        break;

    case 'eliminar':
        if (!isset($data['id'])) {
            echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
            exit;
        }
        
        $query = "DELETE FROM comentarios WHERE id = ?";
        $stmt = $conexion->prepare($query);
        try {
            $stmt->execute([$data['id']]);
            echo json_encode(['success' => true, 'message' => 'Comentario eliminado correctamente']);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar comentario']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Operación no válida']);
        break;
}
?>
