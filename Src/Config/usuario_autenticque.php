use \Firebase\JWT\JWT;

function generateJWT($user) {
    $key = "252411";
    $payload = array(
        "iss" => "tu_dominio.com",
        "aud" => "tu_dominio.com",
        "iat" => time(),
        "nbf" => time(),
        "exp" => time() + (60*60), // Token válido por 1 hora
        "data" => array(
            "id" => $user['id_usuario'],
            "nombre" => $user['nombre'],
            "correo_electronico" => $user['correo_electronico']
        )
    );

    return JWT::encode($payload, $key, 'HS256');
}