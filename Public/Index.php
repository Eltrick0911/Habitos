<?php
    require dirname(__DIR__).'vendor/autoload.php';
	if(isset($_GET[‘route’])){
        $url = explode(‘/’,$_GET[‘route’]); 
	$lista = [‘auth’, ‘user’]; // lista de rutas permitidas
$file = dirname(_DIR_) . ‘/src/Routes/’ . $url[0] . ‘.php’;
		echo 'existe la variable route';
        if(!in_array($url[0], $lista)){
            echo "LA ruta no existe";
           //header(‘HTTP/1.1 404 Not Found’);
            exit; //finalizamos la ejecución
        } 
        //validamos que el archivo exista y que es legible
    if(!file_exists($file) || !is_readable($file)){
        echo "El archivo no existe o no es legible";
    }else{
        require $file;
        exit;
    }

    
	}else{
		echo 'no existe la variable route';
	}
