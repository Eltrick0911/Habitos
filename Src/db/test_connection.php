<?php
include_once '../app/config/Database.php';

$database = new Database();
$db = $database->getConnection();

if ($db) {
    echo "Conexión exitosa a la base de datos";
} else {
    echo "Conexión fallida";
}
?>
