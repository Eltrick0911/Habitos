<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include "../includes/clases/clase_usuario.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos de la solicitud POST
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['nombre']) && isset($data['apellidos']) && isset($data['correo_electronico']) && isset($data['contrasena']) && isset($data['fecha_nacimiento']) && isset($data['genero']) && isset($data['pais_region']) && isset($data['nivel_suscripcion']) && isset($data['preferencias_notificacion'])) {

        $usuario = new Usuario();
        $correo_electronico = $data['correo_electronico'];
        $num = $usuario->existeUsuario($correo_electronico);

        if ($num != 0) {
            header('HTTP/1.1 404 El registro ya existe en la BD!');
            echo json_encode(["error" => "El registro ya existe en la BD!"]);
        } else {
            try {
                // Crear el usuario
                $usuario->crear_usuario(
                    $data['nombre'], 
                    $data['apellidos'], 
                    $data['correo_electronico'], 
                    $data['contrasena'], 
                    $data['fecha_nacimiento'], 
                    $data['genero'], 
                    $data['pais_region'], 
                    $data['nivel_suscripcion'], 
                    $data['preferencias_notificacion']
                );

                // Obtener el objeto PDO de conexión a la base de datos
                $db = new clase_conexion();
                $con = $db->abrirConexion();

                // Obtener el ID del usuario recién creado
                $usuario_id = $con->lastInsertId();

                // Insertar el tipo de usuario por defecto como 'usuario'
                $stmt = $con->prepare('INSERT INTO tipos_usuario (id_usuario, tipo) VALUES (?, "usuario")');
                $stmt->execute([$usuario_id]);

                header('HTTP/1.1 201 El usuario se registró exitosamente!');
                echo json_encode(["message" => "El usuario se registró exitosamente!"]);

            } catch (PDOException $e) {
                header('HTTP/1.1 500 Error al registrar el usuario!');
                echo json_encode(["error" => "Error al registrar el usuario: " . $e->getMessage()]);
            }
        }
    } else {
        header('HTTP/1.1 400 Faltan datos en la solicitud!');
        echo json_encode(["error" => "Faltan datos en la solicitud!"]);
    }
} else {
    header('HTTP/1.1 405 Método no permitido!');
    echo json_encode(["error" => "Método no permitido!"]);
}
?>