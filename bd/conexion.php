<?php
class Conexion extends PDO
{
    protected $database_host = "localhost";
    protected $database_name = "seguimientohabitos";
    protected $database_user = "root";
    protected $database_pass = "252411";
    
    public function __construct()
    {
        try {
            parent::__construct('mysql:host=' . $this->database_host . ';dbname=' . $this->database_name . ';charset=utf8', 
                $this->database_user, $this->database_pass, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
            
        } catch(PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            exit;
        }
    }
}
?>
