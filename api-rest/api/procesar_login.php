<?php
// Temporalmente habilitamos los errores para debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Obtener el origen de la solicitud
$origin = $_SERVER['HTTP_ORIGIN'] ?? '';

// Permitir solo orígenes de localhost con cualquier puerto
if (preg_match('/^http:\/\/localhost(:[0-9]+)?$/', $origin)) {
    header("Access-Control-Allow-Origin: " . $origin);
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../includes/clases/clase_usuario.php";
require_once "../../src/config/Security.php";
require_once $_SERVER['DOCUMENT_ROOT'] . '/Habitos/vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        if (!isset($data['email']) || !isset($data['password'])) {
            throw new Exception("Datos de login incompletos");
        }

        $correo_electronico = $data['email'];
        $contrasena = $data['password'];

        $usuario = new usuario();
        $resultado = $usuario->validar_login($correo_electronico, $contrasena);

        if ($resultado['resultado'] == 1) {
            $_SESSION['usuario_id'] = $resultado['id_usuario'];
            $_SESSION['tipo_usuario'] = $resultado['tipo_usuario'];
            $_SESSION['logged_in'] = true;
            $_SESSION['s_usuario'] = $correo_electronico;
            
            // Obtener datos del usuario
            $stmt = $usuario->getUsuario($resultado['id_usuario']);
            $datos_usuario = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$datos_usuario) {
                throw new Exception("No se encontraron datos del usuario");
            }

            $nombre_completo = $datos_usuario['nombre'] . ' ' . $datos_usuario['apellidos'];
            $_SESSION['nombre_completo'] = $nombre_completo;
            
            // Datos del usuario para el token
            $userData = [
                'id' => $resultado['id_usuario'],
                'email' => $correo_electronico,
                'tipo_usuario' => $resultado['tipo_usuario']
            ];
            // Generar el JWT    
            $security = new \App\config\Security();
            $key = $security->secretKey();
            $jwt = $security->createTokenJwt($key, $userData);

            echo json_encode([
                'success' => true,
                'token' => $jwt, // Enviar el token al cliente
                'tipo_usuario' => $resultado['tipo_usuario'],
                'nombre_completo' => $nombre_completo,
                'usuario_id' => $resultado['id_usuario'],
                'email' => $correo_electronico
            ]);
        } else {
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'error' => 'Credenciales inválidas'
            ]);
        }
    } catch (Exception $e) {
        error_log("Error en login: " . $e->getMessage());
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'error' => $e->getMessage()
        ]);
    }
}
?>