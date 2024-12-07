<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With");
header("Access-Control-Allow-Credentials: true");

// Manejar preflight request
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once "../includes/clases/clase_comentarios.php";

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['grupo_id'])) {
        $grupo_id = $_GET['grupo_id'];

        try {
            $comentarios = new comentarios();
            $resultado = $comentarios->getComentariosPorGrupo($grupo_id);
            $comentarios_lista = $resultado->fetchAll(PDO::FETCH_ASSOC);
            
            if ($comentarios_lista) {
                echo json_encode([
                    'status' => 'success',
                    'data' => $comentarios_lista
                ]);
            } else {
                echo json_encode([
                    'status' => 'success',
                    'data' => []
                ]);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    } else {
        http_response_code(400);
        echo json_encode([
            'status' => 'error',
            'message' => 'Falta el parámetro grupo_id'
        ]);
    }
} else {
    http_response_code(405);
    echo json_encode([
        'status' => 'error',
        'message' => 'Método no permitido'
    ]);
}
?> 