<?php
// Eliminar la cookie estableciendo un tiempo de expiración pasado
setcookie("auth_token", "", [
    'expires' => time() - 3600,
    'path' => '/',
    'httponly' => true,
    'secure' => true,
    'samesite' => 'Strict'
]);

// Redirigir al login
header("Location: ../views/dashboard.php");
exit();
?>