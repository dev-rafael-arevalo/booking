<?php
// Incluir los controladores y modelos
require_once __DIR__ . '/../Controllers/PersonController.php';
require_once __DIR__ . '/../Controllers/UserController.php';

// Crear instancias de los controladores
$personController = new PersonController();
$userController = new UserController();

// Recoger los datos del formulario
$fullname = $_POST['fullname'];
$address = $_POST['address'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$username = $_POST['username'];
$password = $_POST['password'];
$confirm_password = $_POST['confirm_password'];
$role = 3; //Se asume que es un cliente
$destination = $_POST['destination'];  
$active = 1;
$create_user = 'website';

// Validación de las contraseñas
if ($password !== $confirm_password) {
    $error_message= "Las contraseñas no coinciden";
    header("Location: ../views/register_form.php?error=" . urlencode($error_message));
}

// Crear persona
$createPersonResult = $personController->createPerson($fullname, $address, $email, $phone, $destination, $active, $create_user);

// Si la persona se creó correctamente, proceder con el registro del usuario
if (isset($createPersonResult['success'])) {
    // Recuperar el ID de la persona 
    $personId = $personController->getPersonByEmail($email)['id'];    
    $createUserResult = $userController->createUser($username, $password, $personId, $role, true, $username);    
    // Verificar si el usuario se creó correctamente
    if (isset($createUserResult['success'])) {
        echo "Cuenta creada exitosamente.";
    } else {
        $error_message= "Error durante la creación de la cuenta: " . $createUserResult['error'];
        header("Location: ../views/register.php?error=" . urlencode($error_message));
    }
} else {
    $error_message= "Error durante la creación de la cuenta: " . $createPersonResult['error'];
    header("Location: ../views/register.php?error=" . urlencode($error_message));
}
?>
