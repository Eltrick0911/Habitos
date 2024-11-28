<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once 'dataDB.php';
require '../../vendor/autoload.php';
use App\db\connectionDB;

// Suponiendo que dataDB.php contiene constantes para las credenciales
// y connectionDB.php tiene una función getConnection()

try {
    $db = new connectionDB();
    $conn = $db->getConnection();

    // Ejecutar una consulta simple para verificar la conexión
    $stmt = $conn->query("SELECT * FROM Usuario");
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($result) {
        echo "Conexión exitosa. Se encontraron " . count($result) . " registros.";
        $id = filter_input(INPUT_GET,"id_Usuario");
$usuario = new Usuario();
$registros = $usuario->getUsuario($id);
$contador = $registros->fetch(PDO::FETCH_ASSOC);
echo json_encode($contador);
    } else {
        echo "No se encontraron registros.";
    }
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
