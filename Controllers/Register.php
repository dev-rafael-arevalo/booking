<?php

require_once __DIR__ . '/../app/Controllers/RegisterController.php';
require_once __DIR__ . '/../config/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recibe los datos del formulario
    $personData = [
        'full_name' => $_POST['full_name'] ?? '',
        'address' => $_POST['address'] ?? '',
        'email' => $_POST['email'] ?? '',
        'phone' => $_POST['phone'] ?? '',
        'iso_country' => $_POST['iso_country'] ?? '',
        'active' => true,
        'create_user' => 'system', // Esto podría cambiar dependiendo de tu sistema
        'create_date' => date('Y-m-d H:i:s'),
    ];

    $userData = [
        'login' => $_POST['login'] ?? '',
        'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
        'id_role' => 2, // Por ejemplo, rol de "usuario estándar"
        'active' => true,
        'create_user' => 'system',
        'create_date' => date('Y-m-d H:i:s'),
    ];

    // Llama al controlador para registrar la información
    $result = RegisterController::register($personData, $userData);

    if ($result['success']) {
        echo "Registro exitoso. ID de Persona: {$result['person_id']}, ID de Usuario: {$result['user_id']}";
    } else {
        echo "Error: {$result['message']}";
    }
} else {
    echo "Método no permitido.";
}
