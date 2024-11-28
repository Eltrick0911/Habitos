<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../includes/clases/clase_usuario.php";

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    // Obtener los datos de la solicitud PUT
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['id_usuario']) && isset($data['correo_electronico']) && isset($data['contrasena']) && isset($data['fecha_nacimiento']) && isset($data['genero']) && isset($data['pais_region']) && isset($data['nivel_suscripcion']) && isset($data['preferencias_notificacion'])) {
        $usuario = new Usuario();
        $id_usuario = $data['id_usuario'];
        $correo_electronico = $data['correo_electronico'];

        // Verificar si el usuario existe y si el ID coincide con el correo electrónico
        $usuario_existente = $usuario->existeUsuario($correo_electronico);

        if (!$usuario_existente) {
            header('HTTP/1.1 404 El usuario no existe en la BD!');
            echo json_encode(["error" => "El usuario no existe en la BD!"]);
        } elseif ($usuario_existente['id_usuario'] != $id_usuario) {
            header('HTTP/1.1 400 El ID del usuario no coincide con el correo electrónico proporcionado!');
            echo json_encode(["error" => "El ID del usuario no coincide con el correo electrónico proporcionado!"]);
        } else {
            // No permitir modificar nombre ni apellido
            $nombre = $usuario_existente['nombre'];
            $apellidos = $usuario_existente['apellidos'];

            $usuario->actualizarUsuario($id_usuario, $nombre, $apellidos, $data['correo_electronico'], $data['contrasena'], $data['fecha_nacimiento'], $data['genero'], $data['pais_region'], $data['nivel_suscripcion'], $data['preferencias_notificacion']);
            header('HTTP/1.1 200 El usuario se actualizó exitosamente!');
            echo json_encode(["message" => "El usuario se actualizó exitosamente!"]);
        }
    } else {
        header('HTTP/1.1 400 Faltan datos en la solicitud!');
        echo json_encode(["error" => "Faltan datos en la solicitud!"]);
    }
} else {
    header('HTTP/1.1 405 Método no permitido!');
    echo json_encode(["error" => "Método no permitido!"]);
}