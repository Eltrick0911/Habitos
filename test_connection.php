<?php
require 'vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

try {
    $conn = new PDO(
        "mysql:host={$_ENV['IP']};port={$_ENV['PORT']};dbname={$_ENV['DB']}",
        $_ENV['USER'],
        $_ENV['PASSWORD']
    );
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexión exitosa a la base de datos!\n";
    
    // Probar una consulta simple
    $stmt = $conn->query("SHOW TABLES");
    echo "\nTablas en la base de datos:\n";
    while ($row = $stmt->fetch()) {
        echo "- " . $row[0] . "\n";
    }
} catch(PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
}
?>
