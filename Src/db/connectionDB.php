<?php

namespace App\db;

use App\config\responseHTTP;
use PDO;

require '../../vendor/autoload.php';

class connectionDB {
    private static $host;
    private static $user;
    private static $pass;

    public static function inicializar($host, $user, $pass) {
        self::$host = $host;
        self::$user = $user;
        self::$pass = $pass;
    }


    final public static function getConnection(){
        try{
            //opciones de conexion
            $opt = [\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC];
            $pdo = new PDO(self::$host,self::$user,self::$pass, $opt);
            $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            error_log("Conexión exitosa");
            return $pdo;
        }catch(\PDOException $e){
            error_log("Error en la conexión a la BD! ERROR: ".$e);
            die(json_encode(responseHTTP::status500()));

        }
    }
   
}