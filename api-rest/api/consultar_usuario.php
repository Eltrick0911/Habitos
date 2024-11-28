<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require_once("../includes/clases/clase_usuario.php");

// Obtener el ID del usuario desde la solicitud GET
$id = filter_input(INPUT_GET, "id_usuario", FILTER_VALIDATE_INT);

$usuario = new Usuario();

if ($id === null || $id === false) {
    // Si no se proporciona un ID, obtener todos los registros
    $registros = $usuario->getTodosUsuarios();
    $usuarios = $registros->fetchAll(PDO::FETCH_ASSOC);

    if ($usuarios) {
        echo json_encode($usuarios);
    } else {
        echo json_encode(["error" => "No se encontraron usuarios"]);
    }
} else {
    // Si se proporciona un ID, obtener el registro específico
    $registros = $usuario->getUsuario($id);
    $contador = $registros->fetch(PDO::FETCH_ASSOC);

    if ($contador) {
        echo json_encode($contador);
    } else {
        echo json_encode(["error" => "Usuario no encontrado"]);
    }
}