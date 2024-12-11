<?php
require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

class Conexion extends PDO
{
    protected $database_host;
    protected $database_name;
    protected $database_user;
    protected $database_pass;

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable(__DIR__ . '/../');
        $dotenv->load();

        $this->database_host = $_ENV['IP'];
        $this->database_name = $_ENV['DB'];
        $this->database_user = $_ENV['USER'];
        $this->database_pass = $_ENV['PASSWORD'];

        try {
            parent::__construct(
                'mysql:host=' . $this->database_host . ';dbname=' . $this->database_name . ';charset=utf8',
                $this->database_user,
                $this->database_pass,
                array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            exit;
        }
    }
}
?>
