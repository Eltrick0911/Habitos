<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../routes/routes.php';

$requestMethod = $_SERVER["REQUEST_METHOD"];
$path = explode('/', trim($_SERVER['PATH_INFO'],'/'));

if ($requestMethod == 'GET' && $path[0] == 'login') {
    include '../views/login.php';
} elseif ($requestMethod == 'GET' && $path[0] == 'register') {
    include '../views/register.php';
} elseif ($requestMethod == 'GET' && $path[0] == 'dashboard') {
    include '../views/Inicio.php';
} else {
    include '../routes/routes.php';
}
?

<?php
use App\config\errorlogs;
use App\config\responseHTTP;
require dirname(__DIR__).'/vendor/autoload.php';
errorlogs::activa_error_logs();
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
        require $file;
        exit;
    }

}else{
    //la variable GET route no esta definida
    echo json_encode(responseHTTP::status404());
}