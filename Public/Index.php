<?php
use App\config\errorlogs;
use App\config\responseHTTP;
require dirname(__DIR__).'/vendor/autoload.php';
errorlogs::activa_error_logs();
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$path = explode('/', trim($_SERVER['REQUEST_URI'],'/'));

// Eliminar la primera parte de la ruta si es "Habitos"
if ($path[0] == 'Habitos') {
    array_shift($path); 
}

if ($requestMethod == 'GET' && $path[0] == 'login') {
    include 'src/Routes/views/login.html'; 
} elseif ($requestMethod == 'POST' && $path[0] == 'login') {
    // Incluir el archivo login.php para manejar el login
    require_once __DIR__ . '/src/Controllers/login.php'; 
} elseif ($requestMethod == 'GET' && $path[0] == 'register') {
    include 'src/Routes/views/register.html';
} elseif ($requestMethod == 'GET' && $path[0] == 'inicio') {
    include 'src/Routes/views/index.html'; 
} else {
    http_response_code(404);
    echo "Página no encontrada";
}