<?php
    use App\config\responseHTTP;
    require dirname(__DIR__).'vendor/autoload.php';

	if(isset($_GET[‘route’])){
        $url = explode(‘/’,$_GET[‘route’]); 
	$lista = [‘auth’, ‘user’]; // lista de rutas permitidas
$file = dirname(_DIR_) . ‘/src/Routes/’ . $url[0] . ‘.php’;
		
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
