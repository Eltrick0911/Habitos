<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\config\errorlogs;
use App\controllers\userController;

// Configurar el registro de errores
errorlogs::activa_error_logs();

// Incluir la configuración de la base de datos
require_once __DIR__ . '/src/config/datadb.php';

// Obtener la ruta y el método HTTP de la solicitud
$route = $_GET['route'] ?? '/';
$method = $_SERVER['REQUEST_METHOD'];

// Obtener los datos de la solicitud
$data = match ($method) {
    'POST' => json_decode(file_get_contents('php://input'), true),
    'PUT' => json_decode(file_get_contents('php://input'), true),
    default => $_GET,
};

// Obtener los headers de la solicitud
$headers = getallheaders();

// Instanciar el controlador
$controller = new userController($method, $route, $_GET, $data, $headers);

// Mapear la ruta al método del controlador
switch ($route) {
    case '/api/usuarios':
        switch ($method) {
            case 'POST':
                $controller->post();
                break;
            case 'PUT':
                $controller->put();
                break;
            case 'DELETE':
                $controller->delete();
                break;
            case 'GET':
                $controller->get();
                break;
            default:
                http_response_code(405); // Method Not Allowed
                echo json_encode(['error' => 'Método no permitido']);
        }
        break;
    default:
        http_response_code(404); // Not Found
        echo json_encode(['error' => 'Ruta no encontrada']);
}