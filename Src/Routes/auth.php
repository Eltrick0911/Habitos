<?php
use App\controllers\userController;
$route = isset($_GET['route']) ? $_GET['route'] : null;
$method = $_SERVER['REQUEST_METHOD'];
$params = $_GET;
$data = json_decode(file_get_contents('php://input'), true);
$headers = getallheaders();

if ($route === null) {
    die(json_encode(['message' => 'Ruta no definida', 'debug' => $_GET]));
}

$controller = new userController($method, $route, $params, $data, $headers);

switch ($route) {
    case 'login':
        $controller->getLogin($route);
        break;
    case 'register':
        $controller->post($route);
        break;
    // Añade más casos según tus rutas
    default:
        echo json_encode(['message' => 'Ruta no válida']);
        break;
}