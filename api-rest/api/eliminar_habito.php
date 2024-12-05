<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../includes/clases/clase_habitos.php";

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // Obtener los datos de la solicitud DELETE
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id_habito'])) {
        $habitos = new habitos();
        
        try {
            $habitos->eliminarHabito($data['id_habito']);
            header('HTTP/1.1 200 El hábito se eliminó exitosamente!');
            echo json_encode(["message" => "El hábito se eliminó exitosamente!"]);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Error al eliminar el hábito!');
            echo json_encode(["error" => "Error al eliminar el hábito: " . $e->getMessage()]);
        }
    } else {
        header('HTTP/1.1 400 Falta el ID del hábito!');
        echo json_encode(["error" => "Falta el ID del hábito!"]);
    }
} else {
    header('HTTP/1.1 405 Método no permitido!');
    echo json_encode(["error" => "Método no permitido!"]);
}
?>