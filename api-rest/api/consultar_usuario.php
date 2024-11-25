<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
require_once("../includes/clases/clase_usuario.php");
use App\db\connectionDB;

//$pdo = $database->abrirConexion();
$id = filter_input(INPUT_GET,"id_Usuario");
$usuario = new Usuario();
$registros = $usuario->getUsuario($id);
$contador = $registros->fetch(PDO::FETCH_ASSOC);
echo json_encode($contador);

