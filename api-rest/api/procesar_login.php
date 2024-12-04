<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");

require_once "../includes/clases/clase_conexion.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener los datos del formulario
    $correo_electronico = $_POST['email'];
    $contrasena = $_POST['password'];

    try {
        // Conectar a la base de datos
        $db = new clase_conexion();
        $con = $db->abrirConexion();

        // Llamar al procedimiento almacenado para validar el login
        $stmt = $con->prepare("CALL validar_login(?, ?, @resultado, @tipo_usuario)");
        $stmt->bindParam(1, $correo_electronico, PDO::PARAM_STR);
        $stmt->bindParam(2, $contrasena, PDO::PARAM_STR);
        $stmt->execute();

        // Obtener los resultados del procedimiento almacenado
        $result = $con->query("SELECT @resultado, @tipo_usuario");
        $row = $result->fetch(PDO::FETCH_ASSOC);
        $resultado_login = $row['@resultado'];
        $tipo_usuario = $row['@tipo_usuario'];

        // Enviar la respuesta en formato JSON
        if ($resultado_login == 1) {
            // Iniciar sesión (guardar el ID del usuario en una sesión, por ejemplo)
            session_start();
            $_SESSION['usuario_id'] = obtenerIdUsuario($correo_electronico, $con); // Debes implementar esta función

            echo json_encode(['tipo_usuario' => $tipo_usuario]);
        } else {
            echo json_encode(['error' => 'Correo electrónico o contraseña incorrectos.']);
        }

    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error al procesar el login: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Método no permitido.']);
}

// Función para obtener el ID del usuario (debes implementarla)
function obtenerIdUsuario($correo_electronico, $con) {
    try {
        // Preparar la consulta SQL
        $stmt = $con->prepare("SELECT id_usuario FROM Usuario WHERE correo_electronico = ?");
        $stmt->execute([$correo_electronico]);

        // Obtener el ID del usuario
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario) {
            return $usuario['id_usuario'];
        } else {
            return null; // O puedes lanzar una excepción si lo prefieres
        }
    } catch (PDOException $e) {
        // Manejar el error (registrarlo, mostrarlo al usuario, etc.)
        error_log("Error al obtener el ID del usuario: " . $e->getMessage());
        return null; // O puedes lanzar una excepción si lo prefieres
    }
}
?>