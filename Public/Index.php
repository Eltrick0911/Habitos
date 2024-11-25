<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\config\errorlogs;
use App\controllers\userController;

// Configurar el registro de errores
errorlogs::activa_error_logs();
<<<<<<< HEAD
if(isset($_GET['route'])){
    $url = explode('/',$_GET['route']); 
    $lista = ['auth', 'user']; // lista de rutas permitidas
	$file = dirname(__DIR__).'/src/routes/'.$url[0].'.php';
    if(!in_array($url[0], $lista)){
        //LA ruta no existe
        echo json_encode(responseHTTP::status400());
        error_log('Esto es una prueba de un error');
        exit; //finalizamos la ejecución
    } 

    //validamos que el archivo exista y que es legible
    if(!file_exists($file) || !is_readable($file)){
        //El archivo no existe o no es legible
        echo json_encode(responseHTTP::status400());
    }else{
        //echo $file;
        require $file;
        exit;
    }

}else{
    //la variable GET route no esta definida
    echo json_encode(responseHTTP::status404());
=======

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
>>>>>>> 8ae200a0ba886ebd94648aeee02552e90adf52d8
}