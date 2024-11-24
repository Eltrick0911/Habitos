<?php
use App\controllers\userController;
use App\config\responseHTTP;

$method = strtolower($_SERVER['REQUEST_METHOD']); //capturamos el metodo que se envia
$route = $_GET['route']; //capturamos la ruta 
$params = explode('/', $route); // hacemos un explode de route ya que si nos envian user/email/clave tendriamos un array 
$data = json_decode(file_get_contents("php://input"),true); //contendra la data que enviemos por cualquier metodo excepto el get, array asociativo 
$headers = getallheaders(); //capturando todas las cabeceras que nos envian
//echo $method;
$app = new userController($method,$route,$params,$data,$headers); //instancia clase user controlador 
//$app->post("/user");
$app->post('user/'); //llamada al metodo post con la ruta al recurso
 



echo json_encode(responseHTTP::status404()); //imprimamos un error en caso de no encuentre la ruta

