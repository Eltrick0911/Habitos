<?php


class clase_conexion {
    protected $database_host = "localhost";
    protected $database_name = "seguimientohabitos";
    protected $database_user = "root";
    protected $database_pass = "";
    
    public function __construct(){
    }    
    
    //abre conexion
    public function abrirConexion() {
        $opciones = array(
                PDO::ATTR_PERSISTENT => true
        );
        try {
            return new PDO("mysql:host=".$this->database_host.";dbname=".$this->database_name, $this->database_user, $this->database_pass,$opciones);
        } catch (PDOException $e) {
            exit('ERROR al conectarse a la base datos. \nDescripción del ERROR: '.$e);
        }
    } 
}


