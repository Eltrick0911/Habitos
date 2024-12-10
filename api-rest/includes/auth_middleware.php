<?php
// Prevenir múltiples inicios de sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Asegurar que el archivo de clase_usuario existe
$rutaClaseUsuario = __DIR__ . '/clases/clase_usuario.php';
if (!file_exists($rutaClaseUsuario)) {
    throw new Exception('Error: No se encuentra el archivo clase_usuario.php');
}
require_once $rutaClaseUsuario;

class AuthMiddleware {
    public static function verificarAutenticacion() {
        try {
            if (!isset($_SESSION['user_id'])) {
                http_response_code(401);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'No autorizado',
                    'code' => 401
                ]);
                exit();
            }
            return true;
        } catch (Exception $e) {
            error_log("Error en verificarAutenticacion: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Error interno del servidor',
                'code' => 500
            ]);
            exit();
        }
    }

    public static function verificarRol($roles_permitidos) {
        try {
            self::verificarAutenticacion();
            
            if (!isset($_SESSION['rol']) || !in_array($_SESSION['rol'], $roles_permitidos)) {
                http_response_code(403);
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Acceso denegado',
                    'code' => 403
                ]);
                exit();
            }
            return true;
        } catch (Exception $e) {
            error_log("Error en verificarRol: " . $e->getMessage());
            http_response_code(500);
            echo json_encode([
                'status' => 'error',
                'message' => 'Error interno del servidor',
                'code' => 500
            ]);
            exit();
        }
    }

    public static function obtenerUsuarioActual() {
        try {
            if (isset($_SESSION['user_id'])) {
                return $_SESSION['user_id'];
            }
            return null;
        } catch (Exception $e) {
            error_log("Error en obtenerUsuarioActual: " . $e->getMessage());
            return null;
        }
    }
}
