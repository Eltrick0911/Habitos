<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require_once("../includes/clases/clase_usuario.php");

// Obtener el ID del usuario desde la solicitud GET
$id = filter_input(INPUT_GET, "id_usuario", FILTER_VALIDATE_INT);

if ($id === null || $id === false) {
    echo json_encode(["error" => "ID de usuario inválido"]);
    exit;
}

$usuario = new Usuario();
$registros = $usuario->getUsuario($id);
$contador = $registros->fetch(PDO::FETCH_ASSOC);

if ($contador) {
    echo json_encode($contador);
} else {
    echo json_encode(["error" => "Usuario no encontrado"]);
}