<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once "../includes/clases/clase_habitos.php";
require_once "../includes/middleware/AuthMiddleware.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Verificar autenticación
    $userData = AuthMiddleware::verificarToken();
    
    if ($userData) {
        $habitos = new habitos();
        
        // Si se proporciona un ID, obtener un hábito específico
        if (isset($_GET['id_habito'])) {
            $resultado = $habitos->getHabito($_GET['id_habito']);
            $habito = $resultado->fetch(PDO::FETCH_ASSOC);
            
            if ($habito) {
                header('HTTP/1.1 200 OK');
                echo json_encode([
                    'status' => 'success',
                    'data' => $habito
                ]);
            } else {
                header('HTTP/1.1 404 No se encontró el hábito!');
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No se encontró el hábito!'
                ]);
            }
        }
        // Si se proporciona un estado, obtener hábitos por estado
        else if (isset($_GET['estado'])) {
            $resultado = $habitos->getHabitosPorEstado($_GET['estado']);
            $habitos_lista = $resultado->fetchAll(PDO::FETCH_ASSOC);
            
            header('HTTP/1.1 200 OK');
            echo json_encode([
                'status' => 'success',
                'data' => $habitos_lista
            ]);
        }
        // Si se proporciona una categoría, obtener hábitos por categoría
        else if (isset($_GET['categoria'])) {
            $resultado = $habitos->getHabitosPorCategoria($_GET['categoria']);
            $habitos_lista = $resultado->fetchAll(PDO::FETCH_ASSOC);
            
            header('HTTP/1.1 200 OK');
            echo json_encode([
                'status' => 'success',
                'data' => $habitos_lista
            ]);
        }
        // Si no se proporciona ningún parámetro, obtener todos los hábitos
        else {
            $resultado = $habitos->getTodosHabitos();
            $habitos_lista = $resultado->fetchAll(PDO::FETCH_ASSOC);
            
            header('HTTP/1.1 200 OK');
            echo json_encode([
                'status' => 'success',
                'data' => $habitos_lista
            ]);
        }
    } else {
        header('HTTP/1.1 401 No autorizado!');
        echo json_encode([
            'status' => 'error',
            'message' => 'No autorizado!'
        ]);
    }
} else {
    header('HTTP/1.1 405 Método no permitido!');
    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido!'
    ]);
}
?>
