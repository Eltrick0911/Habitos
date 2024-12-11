<?php
require_once __DIR__ . '/../../../vendor/autoload.php'; 

use Dotenv\Dotenv;

class clase_conexion {
    protected $database_host;
    protected $database_name;
    protected $database_user;
    protected $database_pass;

    public function __construct() {
        // Cargar las variables de entorno
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../../');
        $dotenv->load();

        $this->database_host = $_ENV['IP'];
        $this->database_name = $_ENV['DB'];
        $this->database_user = $_ENV['USER'];
        $this->database_pass = $_ENV['PASSWORD'];
    }

    // Abre conexión
    public function abrirConexion() {
        $opciones = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        try {
            return new PDO(
                "mysql:host=".$this->database_host.";dbname=".$this->database_name.";charset=utf8",
                $this->database_user,
                $this->database_pass,
                $opciones
            );
        } catch (PDOException $e) {
            exit('ERROR al conectarse a la base de datos. \nDescripción del ERROR: '.$e->getMessage());
        }
    }
}
?>


