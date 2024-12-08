<?php

namespace App\config; //nombre de espacios

use Dotenv\Dotenv; //variables de entorno https://github.com/vlucas/phpdotenv 
use Firebase\JWT\JWT; //para generar nuestro JWT https://github.com/firebase/php-jwt
use Firebase\JWT\Key; //para manejar las claves de JWT

class Security {

    private static $jwt_data;//Propiedad para guardar los datos decodificados del JWT 
    private static $secret_key;
    public function __construct() {
        self::$secret_key = 'tu_clave_secreta'; // Idealmente esto debería estar en un .env
    }

    /*METODO para Acceder a la secret key para crear el JWT*/
    final public static function secretKey()
    {
        try {
            if (!isset(self::$secret_key)) {
                $dotenv = \Dotenv\Dotenv::createImmutable(dirname(__DIR__,2));
                $dotenv->load();
                
                if (!isset($_ENV['SECRET_KEY'])) {
                    throw new \RuntimeException('La variable SECRET_KEY no está definida en el archivo .env');
                }
                
                self::$secret_key = $_ENV['SECRET_KEY'];
            }
            
            return self::$secret_key;
        } catch (\Throwable $e) {
            error_log($e->getMessage());
            throw $e;
        }
    }


    /*METODO para Encriptar la contraseña del usuario*/
    final public static function createPassword(string $pass)
    {
        $pass = password_hash($pass,PASSWORD_DEFAULT); //metodo para encriptar mediante hash
        //recibe 2 parametros el primero el la cadena (pass) y el segundo es el metodo de encriptación (por defecto BCRIPT)
        return $pass;
    }

    /*PARAM: 1.	SECRET_KEY
             2.	ARRAY con la data que queremos encriptar*/

    final public static function createTokenJwt(string $key , array $data)
    {
        $payload = array ( //Cuerpo del JWT
            "iat" => time(),  //clave que almacena el tiempo en el que creamos el JWT
            "exp" => time() + (60*60*6), //clave que almacena el tiempo actual en segundos que expira el JWT
            //si solo colocamos 10 entonces expirara en 10 segundos
            "data" => $data //clave que almacena la data encriptada
        );
        
        //creamos el JWT recibe varios parametros pero nos interesa el payload y la key en el metodo encode de JWT
        $jwt = JWT::encode($payload, $key, 'HS256');
       // print_r($jwt);
        return $jwt;
    }

    /*Validamos que el JWT sea correcto*/
    final public static function validateTokenJwt($token)
    {
        try {
            $key = self::secretKey();
            $decoded = JWT::decode($token, new Key($key, 'HS256'));
            self::$jwt_data = $decoded;
            return $decoded;
        } catch (\Exception $e) {
            throw new \Exception("Token inválido: " . $e->getMessage());
        }
    }

    /*Devolver los datos del JWT decodificados en un array asociativo*/
    final public static function getDataJwt()
    {
        $jwt_decoded_array = json_decode(json_encode(self::$jwt_data),true);
        return $jwt_decoded_array['data'];
        exit;
    }

}