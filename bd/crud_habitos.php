<?php
include_once 'conexion.php';
session_start();

$operacion = isset($_GET['operacion']) ? $_GET['operacion'] : 'consultar';
$conexion = new Conexion();
$data = json_decode(file_get_contents('php://input'), true);

switch($operacion) {
    case 'consultar':
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        if ($id) {
            $query = "SELECT h.*, u.nombre as usuario FROM habitos h 
                     LEFT JOIN usuarios u ON h.id_usuario = u.id 
                     WHERE h.id = ?";
            $stmt = $conexion->prepare($query);
            $stmt->execute([$id]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $query = "SELECT h.*, u.nombre as usuario FROM habitos h 
                     LEFT JOIN usuarios u ON h.id_usuario = u.id";
            $stmt = $conexion->prepare($query);
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode(['success' => true, 'data' => $resultado]);
        break;

    case 'crear':
        if (!isset($data['titulo']) || !isset($data['descripcion']) || !isset($data['id_usuario'])) {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
            exit;
        }
        
        $query = "INSERT INTO habitos (titulo, descripcion, id_usuario) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($query);
        
        try {
            $stmt->execute([$data['titulo'], $data['descripcion'], $data['id_usuario']]);
            echo json_encode(['success' => true, 'message' => 'Hábito creado correctamente']);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error al crear hábito']);
        }
        break;

    case 'actualizar':
        if (!isset($data['id']) || !isset($data['titulo']) || !isset($data['descripcion'])) {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
            exit;
        }
        
        $query = "UPDATE habitos SET titulo = ?, descripcion = ? WHERE id = ?";
        $stmt = $conexion->prepare($query);
        
        try {
            $stmt->execute([$data['titulo'], $data['descripcion'], $data['id']]);
            echo json_encode(['success' => true, 'message' => 'Hábito actualizado correctamente']);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar hábito']);
        }
        break;

    case 'eliminar':
        if (!isset($data['id'])) {
            echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
            exit;
        }
        
        $query = "DELETE FROM habitos WHERE id = ?";
        $stmt = $conexion->prepare($query);
        try {
            $stmt->execute([$data['id']]);
            echo json_encode(['success' => true, 'message' => 'Hábito eliminado correctamente']);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar hábito']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Operación no válida']);
        break;
}
?>
