<?php
require_once('../config/database.php');
require_once('../Models/UserModel.php');
require_once('../Helpers/jwt_helper.php');

// Recibir datos de login
$username = $_POST['username'];
$password = $_POST['password'];

// Instanciar el modelo de usuario
$userModel = new UserModel();

// Validar el login
$userId = $userModel->validateUser($username, $password);
$roleId = $userModel->getUser($userId)['id_role'];
$login = $userModel->getUser($userId)['login'];

if ($userId) {
    // Crear el payload del JWT
    $issuedAt = time();
    $expirationTime = $issuedAt + 86400;  // El token expirará en 1 dialoc
    $payload = array(
        "iat" => $issuedAt,
        "exp" => $expirationTime,
        "userId" => $userId,
        "roleId" => $roleId,
        "login" => $login,
    );

    // Generar el token JWT
    $jwt = encodeJWT($payload);

    // Configurar cookie segura
    setcookie("auth_token", $jwt, [
        'expires' => $expirationTime,
        'path' => '/',
        'httponly' => true, // Previene acceso desde JavaScript
        'secure' => true,   // Requiere HTTPS
        'samesite' => 'Strict' // Previene envío en solicitudes de terceros
    ]);

    

    // Redirigir al dashboard sin pasar el token en la URL
    header("Location: ../views/dashboard.php");
    exit();
} else {
    // Si las credenciales no son correctas, redirigir al login con un mensaje de error
    header("Location: ../views/login_form.php?error=Credenciales inválidas");
    exit();
}

?>
