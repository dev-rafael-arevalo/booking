<?php
require_once('../Helpers/jwt_helper.php');
require_once('../Controllers/ModuleController.php');

$modules=new ModuleController();
$modulesList = $modules->index();


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

        include('navbar.php'); // Incluir la barra de navegación
        if (isset($_GET['mensaje'])){
            echo "<div class='alert alert-success'>".$_GET['mensaje']."</div>";
        }
        
?>
        <div class='row col-md-10 justify-content-between my-5'>
            <span class='col-md-6'>
                <h1 class='h1'>Lista de modules</h1>
            </span>
            <span class='col-md-2'>
                <a href="modules_create.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Módulo
                </a>
            </span>
        </div>
        <div class='row justify-content-center col-lg-10 col-md-10 border-1 border border-warning p-2'>
        <table id="modulesTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>                    
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($modulesList as $modules): ?>
                    <tr>
                        <td class='text-center'><?= htmlspecialchars($modules['id']) ?></td>
                        <td><?= htmlspecialchars($modules['name']) ?></td>                        
                        <td><?= $modules['active'] ? 'Sí' : 'No' ?></td>
                        <td>
                            <a href="modules_edit.php?id=<?= htmlspecialchars($modules['id']) ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="modules_delete.php?id=<?= htmlspecialchars($modules['id']) ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este servicio?');">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>                            
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        </div>


    <?php include('footer.php'); ?> <!-- Incluir el pie de página -->

<?php
    } catch (Exception $e) {
        // Si el token no es válido o ha expirado, redirigir al login
        header("Location: login_form.php?error=Sesión expirada");
        exit();
    }
} else {
    // Si no hay token, redirigir al login
    header("Location: login_form.php");
    exit();
}
?>
