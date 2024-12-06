<?php
session_start();

include_once '../api-rest/includes/clases/clase_conexion.php';
include_once '../api-rest/includes/clases/clase_usuario.php';

//recepción de datos enviados mediante POST desde ajax
$correo = (isset($_POST['usuario'])) ? $_POST['usuario'] : '';
$password = (isset($_POST['password'])) ? $_POST['password'] : '';

try {
    $usuario = new Usuario();
    $resultado = $usuario->validar_login($correo, $password);

    if ($resultado['resultado'] == 1) {
        // Obtener los datos del usuario
        $datosUsuario = Usuario::getUsuario($resultado['id_usuario']);
        
        if ($datosUsuario && $datosUsuario->rowCount() > 0) {
            $datos = $datosUsuario->fetch(PDO::FETCH_ASSOC);
            
            $_SESSION['usuario_id'] = $resultado['id_usuario'];
            $_SESSION['tipo_usuario'] = $resultado['tipo_usuario'];
            $_SESSION["s_usuario"] = $correo; // Mantener compatibilidad con el sistema antiguo

            $data = [
                'success' => true,
                'tipo_usuario' => $resultado['tipo_usuario'],
                'nombre_completo' => $datos['nombre'] . ' ' . $datos['apellidos']
            ];
        } else {
            $_SESSION["s_usuario"] = null;
            $data = [
                'success' => false,
                'error' => 'No se pudieron obtener los datos del usuario'
            ];
        }
    } else {
        $_SESSION["s_usuario"] = null;
        $data = [
            'success' => false,
            'error' => 'Credenciales inválidas'
        ];
    }
} catch (Exception $e) {
    $_SESSION["s_usuario"] = null;
    $data = [
        'success' => false,
        'error' => 'Error al procesar el login: ' . $e->getMessage()
    ];
}

print json_encode($data);