<?php
require_once('../Helpers/jwt_helper.php');
require_once('../Controllers/AccommodationsController.php');
$accommodationController = new AccommodationsController();

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

        // Comprobar si se ha enviado el formulario
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recoger los datos del formulario
            $name = $_POST['name'];
            $address = $_POST['address'];
            $email_contact = $_POST['email_contact'];
            $phone = $_POST['phone'];
            $iso_country = $_POST['destination'];
            $description = $_POST['description'];
            $active = 1;  // Activo por defecto
            $create_user = $userId;
            
            // Validar que los datos no estén vacíos
            if (empty($name) || empty($address) || empty($email_contact) || empty($phone)) {
                echo "<div class='alert alert-danger'>Por favor, completa todos los campos.</div>";
            } else {
                // Crear el nuevo alojamiento
                $mensaje = $accommodationController->store($name, $address, $email_contact, $phone, $iso_country, $description, $active, $create_user);
                $mensaje = 'Alojamiento creado con éxito';
                // Redirigir después de crear (para evitar el reenvío del formulario)
                header("Location: accommodation_list.php?mensaje='" . $mensaje . "'");
                exit();
            }
        }
        include('navbar.php'); // Incluir la barra de navegación
?>

<div class='row col-md-10 justify-content-between my-5'>
    <span class='col-md-6'>
        <h1 class='h1'>Crear nuevo alojamiento</h1>
    </span>
    <span class='col-md-2'>
        <a href="accommodation_list.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </span>            
</div>
<form method="POST" action="accommodation_create.php" class='row col-lg-10 col-md-10 justify-content-center was-validated'>
    <div class="row mb-3 col-lg-12 col-md-12">
        <label for="name" class="form-label required">Nombre del Alojamiento</label>
        <input type="text" class="form-control" id="name" name="name" required>
    </div>
    <div class="row mb-3 col-lg-12 col-md-12">
        <label for="address" class="form-label required">Dirección</label>
        <input type="text" class="form-control" id="address" name="address" required>
    </div>
    <div class="row mb-3 col-lg-12 col-md-12">
        <label for="email_contact" class="form-label">Correo de Contacto</label>
        <input type="email" class="form-control" id="email_contact" name="email_contact">
    </div>
    <div class="row mb-3 col-lg-12 col-md-12">
        <label for="phone" class="form-label">Teléfono</label>
        <input type="tel" class="form-control" id="phone" name="phone">
    </div>
    <div class="row mb-3 col-lg-12 col-md-12">
        <label for="iso_country" class="form-label">País (ISO)</label>
        <select class="form-control form-select select2" id="destination" name="destination" required>
                    <!-- Los destinos se cargarán aquí -->
                </select>
    </div>
    <div class="row mb-3 col-lg-12 col-md-12">
        <label for="description" class="form-label">Descripción</label>
        <textarea class="form-control" id="description" name="description"></textarea>
    </div>
    <button type="submit" class="btn btn-primary col-1 mb-3">Crear Alojamiento</button>
</form>

<?php
        include('footer.php'); // Incluir el pie de página
    } catch (Exception $e) {
        // Si el token no es válido o ha expirado, redirigir al login
        header("Location: login_form.php?error=Sesión expirada");
        exit();
    }
} else {
    // Si no hay token, redirigir al login
    header("Location: ../views/login_form.php?error=La sesión se ha cerrado");
    exit();
}
?>
