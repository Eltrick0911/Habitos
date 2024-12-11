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
            $query = "SELECT id, nombre, email, fecha_registro FROM usuarios WHERE id = ?";
            $stmt = $conexion->prepare($query);
            $stmt->execute([$id]);
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $query = "SELECT id, nombre, email, fecha_registro FROM usuarios";
            $stmt = $conexion->prepare($query);
            $stmt->execute();
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        echo json_encode(['success' => true, 'data' => $resultado]);
        break;

    case 'crear':
        if (!isset($data['nombre']) || !isset($data['email']) || !isset($data['password'])) {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
            exit;
        }
        
        $query = "INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
        
        try {
            $stmt->execute([$data['nombre'], $data['email'], $password_hash]);
            echo json_encode(['success' => true, 'message' => 'Usuario creado correctamente']);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error al crear usuario']);
        }
        break;

    case 'actualizar':
        if (!isset($data['id']) || !isset($data['nombre']) || !isset($data['email'])) {
            echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
            exit;
        }
        
        $query = "UPDATE usuarios SET nombre = ?, email = ? WHERE id = ?";
        $params = [$data['nombre'], $data['email'], $data['id']];
        
        if (isset($data['password']) && !empty($data['password'])) {
            $query = "UPDATE usuarios SET nombre = ?, email = ?, password = ? WHERE id = ?";
            $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);
            $params = [$data['nombre'], $data['email'], $password_hash, $data['id']];
        }
        
        $stmt = $conexion->prepare($query);
        try {
            $stmt->execute($params);
            echo json_encode(['success' => true, 'message' => 'Usuario actualizado correctamente']);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar usuario']);
        }
        break;

    case 'eliminar':
        if (!isset($data['id'])) {
            echo json_encode(['success' => false, 'message' => 'ID no proporcionado']);
            exit;
        }
        
        $query = "DELETE FROM usuarios WHERE id = ?";
        $stmt = $conexion->prepare($query);
        try {
            $stmt->execute([$data['id']]);
            echo json_encode(['success' => true, 'message' => 'Usuario eliminado correctamente']);
        } catch(PDOException $e) {
            echo json_encode(['success' => false, 'message' => 'Error al eliminar usuario']);
        }
        break;

    default:
        echo json_encode(['success' => false, 'message' => 'Operación no válida']);
        break;
}
?>
