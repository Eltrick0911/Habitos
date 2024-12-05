<?php
header("Access-Control-Allow-Origin: http://127.0.0.1:5501");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Content-Type: application/json; charset=UTF-8");

require_once "../includes/clases/clase_usuario.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $correo_electronico = $data['email'];
        $contrasena = $data['password'];

        $usuario = new usuario();
        $resultado = $usuario->validar_login($correo_electronico, $contrasena);

        if ($resultado['resultado'] == 1) {
            // Obtener los datos del usuario
            $datosUsuario = usuario::getUsuario($resultado['id_usuario']);
            
            // Verificar que obtuvimos los datos correctamente
            if ($datosUsuario && $datosUsuario->rowCount() > 0) {
                $datos = $datosUsuario->fetch(PDO::FETCH_ASSOC);
                
                session_start();
                $_SESSION['usuario_id'] = $resultado['id_usuario'];
                $_SESSION['tipo_usuario'] = $resultado['tipo_usuario'];

                echo json_encode([
                    'success' => true,
                    'tipo_usuario' => $resultado['tipo_usuario'],
                    'nombre_completo' => $datos['nombre'] . ' ' . $datos['apellidos']
                ]);
            } else {
                echo json_encode([
                    'success' => false,
                    'error' => 'No se pudieron obtener los datos del usuario'
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'error' => 'Credenciales inválidas'
            ]);
        }

    } catch (Exception $e) {
        echo json_encode([
            'success' => false,
            'error' => 'Error al procesar el login: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'error' => 'Método no permitido.'
    ]);
}
?>