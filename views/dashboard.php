<?php
require_once('../Helpers/jwt_helper.php');

// Verificar si existe la cookie con el token
if (isset($_COOKIE['auth_token'])) {
    $jwt = $_COOKIE['auth_token'];

    try {
        // Decodificar y validar el token JWT
        $payload = decodeJWT($jwt);

        // Validar si el token ha expirado
        if ($payload['exp'] < time()) {
            throw new Exception("El token ha expirado.");
        }

        // El usuario está autenticado, puedes acceder a $payload['userId'] aquí
        $userId = $payload['userId'];        
        include('navbar.php');        
        include('search.php');        
        include('footer.php');
    } catch (Exception $e) {
        // Si el token no es válido o ha expirado, redirigir al login
        header("Location: ./views/login_form.php?error=Sesión expirada");
        exit();
    }
} else {
    // Si no hay token, redirigir al login
    include('navbar.php');        
        include('search.php');        
        include('footer.php');
    exit();
}

?>
