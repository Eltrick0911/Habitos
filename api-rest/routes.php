<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Obtener el método HTTP y la ruta solicitada
$method = $_SERVER['REQUEST_METHOD'];
$request = $_SERVER['REQUEST_URI'];

// Eliminar la parte base de la URL para obtener solo la ruta
$base_path = '/Habitos/api-rest';
$route = str_replace($base_path, '', $request);

// Definir las rutas y sus controladores
$routes = [
    // Rutas de usuarios
    'POST /auth/login' => 'api/procesar_login.php',
    'POST /auth/register' => 'api/crear_usuario.php',
    'PUT /users/update' => 'api/actualizar_usuario.php',
    'GET /users/profile' => 'api/consultar_usuario.php',
    
    // Rutas de hábitos
    'GET /habits' => 'api/consultar_todos_habitos.php',
    'GET /habits/{id}' => 'api/consultar_habito.php',
    'POST /habits/create' => 'api/crear_habito.php',
    'PUT /habits/update' => 'api/actualizar_habito.php',
    'DELETE /habits/{id}' => 'api/eliminar_habito.php',
    
    // Rutas de comentarios
    'GET /comments/group/{id}' => 'api/consultar_comentarios_por_grupo.php',
    'POST /comments/create' => 'api/crear_comentario.php',
    'PUT /comments/update' => 'api/actualizar_comentario.php',
    'DELETE /comments/{id}' => 'api/eliminar_comentario.php'
];

// Función para manejar parámetros en la URL
function matchRoute($route, $path) {
    $route_parts = explode('/', trim($route, '/'));
    $path_parts = explode('/', trim($path, '/'));
    
    if (count($route_parts) !== count($path_parts)) {
        return false;
    }
    
    $params = [];
    for ($i = 0; $i < count($route_parts); $i++) {
        if (preg_match('/^{.+}$/', $route_parts[$i])) {
            $params[trim($route_parts[$i], '{}')] = $path_parts[$i];
        } elseif ($route_parts[$i] !== $path_parts[$i]) {
            return false;
        }
    }
    
    return $params;
}

// Manejar la solicitud
$route_found = false;
foreach ($routes as $route_pattern => $handler) {
    list($route_method, $route_path) = explode(' ', $route_pattern);
    
    if ($method === $route_method) {
        $params = matchRoute($route_path, $route);
        if ($params !== false) {
            $_REQUEST['route_params'] = $params;
            require __DIR__ . '/' . $handler;
            $route_found = true;
            break;
        }
    }
}

if (!$route_found) {
    http_response_code(404);
    echo json_encode(['error' => 'Ruta no encontrada']);
}
?>
