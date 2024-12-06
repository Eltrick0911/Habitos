<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../includes/clases/clase_habitos.php";

if ($_SERVER['REQUEST_METHOD'] == 'PUT' || $_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Validar que todos los campos requeridos estén presentes
    $required_fields = [
        'id_habito', 'nombre_habito', 'descripcion_habito', 'categoria_habito', 
        'objetivo_habito', 'frecuencia', 'duracion_estimada', 
        'estado', 'fecha_inicio', 'fecha_estimacion_final'
    ];

    $missing_fields = array_diff($required_fields, array_keys($data));

    if (empty($missing_fields)) {
        // Validar el enum de frecuencia
        $frecuencias_validas = ['diaria', 'semanal', 'mensual', 'personalizada'];
        if (!in_array($data['frecuencia'], $frecuencias_validas)) {
            header('HTTP/1.1 400 Frecuencia no válida!');
            echo json_encode(["error" => "La frecuencia debe ser: diaria, semanal, mensual o personalizada"]);
            exit;
        }

        // Validar el enum de estado
        $estados_validos = ['activo', 'pausado', 'completado'];
        if (!in_array($data['estado'], $estados_validos)) {
            header('HTTP/1.1 400 Estado no válido!');
            echo json_encode(["error" => "El estado debe ser: activo, pausado o completado"]);
            exit;
        }

        $habitos = new habitos();
        
        try {
            $habitos->actualizarHabito(
                $data['id_habito'],
                $data['nombre_habito'],
                $data['descripcion_habito'],
                $data['categoria_habito'],
                $data['objetivo_habito'],
                $data['frecuencia'],
                $data['duracion_estimada'],
                $data['estado'],
                $data['fecha_inicio'],
                $data['fecha_estimacion_final']
            );
            
            header('HTTP/1.1 200 El hábito se actualizó exitosamente!');
            echo json_encode(["message" => "El hábito se actualizó exitosamente!"]);
        } catch (Exception $e) {
            header('HTTP/1.1 500 Error al actualizar el hábito!');
            echo json_encode(["error" => "Error al actualizar el hábito: " . $e->getMessage()]);
        }
    } else {
        header('HTTP/1.1 400 Faltan campos requeridos!');
        echo json_encode([
            "error" => "Faltan campos requeridos",
            "campos_faltantes" => array_values($missing_fields)
        ]);
    }
} else {
    header('HTTP/1.1 405 Método no permitido!');
    echo json_encode([
        "status" => "error",
        "message" => "Método no permitido!"
    ]);
}
