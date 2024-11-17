<?php
<<<<<<< HEAD
//creamos un espacio de nombres 
//mas adelante lo configuraremos para que el autoload de composer pueda cargarlo de forma dinamica
namespace App\config; //este sera nuestro espacio de nombres

class responseHTTP{
    //definimos una variable llamada mensaje que sera un array asociativo
    public static $mensaje = array(
        'status' => '',
        'message' => '',
        'data' => ''
    );

    //creamos nuestro primer codigo de estado http

    final public static function status200(string $res){
        http_response_code(200);
        self::$mensaje['status'] = 'OK';
        self::$mensaje['message'] = $res; //la variable res es el mensaje/respuesta que proviene del usuario
        return self::$mensaje;
    }

=======

namespace App\Config;

Class responseHTTP{
    public static $mensaje = array(
       'status'=> '',
       'message' =>'',
       'data'=>''
    );
    final public static function status200(string $res){
        self::$mensajee['status']= '200';
        self::$mensajee['status']= $res;
        http_response_code(200);
        
    }
>>>>>>> 32f2ba5ade9aec091ca4bd5a4b8b683671606878
    final public static function status201(){
        $res = 'Recurso creado exitosamente!';
        http_response_code(201);
        self::$mensaje['status'] = 'OK';
        self::$mensaje['message'] = $res; //la variable res es el mensaje
        return self::$mensaje;
    }

    final public static function status400(){
        $res = 'Formato de solicitud incorrecto!';
        http_response_code(400);
        self::$mensaje['status'] = 'ERROR';
        self::$mensaje['message'] = $res; //la variable res es el mensaje
        return self::$mensaje;
    }

    final public static function status401(){
        $res = 'No tiene privilegios para acceder al recurso!';
        http_response_code(401);
        self::$mensaje['status'] = 'ERROR';
        self::$mensaje['message'] = $res; //la variable res es el mensaje
        return self::$mensaje;
    }

    final public static function status404(){
        $res = 'No existe  el recurso solicitado!';
        http_response_code(404);
        self::$mensaje['status'] = 'ERROR';
        self::$mensaje['message'] = $res; //la variable res es el mensaje
        return self::$mensaje;
    }

    final public static function status500(){
        $res = 'Se ha producido un error en el servidor!';
        http_response_code(500);
        self::$mensaje['status'] = 'ERROR';
        self::$mensaje['message'] = $res; //la variable res es el mensaje
        return self::$mensaje;
    }
<<<<<<< HEAD
}
=======
        
    
}
>>>>>>> 32f2ba5ade9aec091ca4bd5a4b8b683671606878
