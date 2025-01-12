<?php
require_once('../Helpers/jwt_helper.php');
require_once('../Controllers/ModuleController.php');
$modulesController = new ModuleController();

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
            $active =  1;

            // Validar que los datos no estén vacíos
            if (empty($name) ) {
                echo "<div class='alert alert-danger'>Por favor, completa todos los campos.</div>";
            } else {
                // Crear el nuevo estado
                $mensaje=$modulesController->store($name, $active, $userId);
                $mensaje='Módulo creado con éxito';
                // Redirigir después de crear (para evitar el reenvío del formulario)
                header("Location: modules_list.php?mensaje='".$mensaje."'");
                exit();
            }
        }
        include('navbar.php'); // Incluir la barra de navegación
?>

<div class='row col-md-10 justify-content-between my-5'>
            <span class='col-md-6'>
                <h1 class='h1'>Crear nuevo estado</h1>
            </span>
            <span class='col-md-2'>
                <a href="modules_list.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </span>            
        </div>
        <form method="POST" action="modules_create.php" class='row col-lg-10 col-md-10 justify-content-center was-validated'>
            <div class="row mb-3 col-lg-12 col-md-12">
                <label for="name" class="form-label required">Nombre del Módulo</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>                
            <button type="submit" class="btn btn-primary col-1 mb-3">Crear Módulo</button>
        </form>
    </div>    
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
