<?php


class clase_conexion {
    protected $database_host = "localhost";
    protected $database_name = "seguimiento_habitos";
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


class login {
    private $host = "localhost";
    private $db_name = "seguimiento_habitos";
    private $username = "root";
    private $password = "";
    public $conn;

    public function  abrirConexion() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }
        return $this->conn;
    }
}
?>