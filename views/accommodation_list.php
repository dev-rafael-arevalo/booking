<?php
require_once('../Helpers/jwt_helper.php');
require_once('../Controllers/AccommodationsController.php');

$accommodation = new AccommodationsController();
$accommodationList = $accommodation->index();

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
                <h1 class='h1'>Lista de Alojamientos</h1>
            </span>
            <span class='col-md-2'>
                <a href="accommodation_create.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Nuevo Alojamiento
                </a>
            </span>
        </div>
        <div class='row justify-content-center col-lg-10 col-md-10 border-1 border border-warning p-2'>
        <table id="accommodationTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Dirección</th>
                    <th>Correo</th>
                    <th>Teléfono</th>
                    <th>País</th>                    
                    <th>Activo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($accommodationList as $accommodation): ?>
                    <tr>
                        <td class='text-center'><?= htmlspecialchars($accommodation['id']) ?></td>
                        <td><?= htmlspecialchars($accommodation['name']) ?></td>
                        <td><?= htmlspecialchars($accommodation['address']) ?></td>
                        <td><?= htmlspecialchars($accommodation['email_contact']) ?></td>
                        <td><?= htmlspecialchars($accommodation['phone']) ?></td>
                        <td><?= htmlspecialchars($accommodation['iso_country']) ?></td>                        
                        <td><?= $accommodation['active'] ? 'Sí' : 'No' ?></td>
                        <td>
                            <a href="accommodation_edit.php?id=<?= htmlspecialchars($accommodation['id']) ?>" class="btn btn-warning">
                                <i class="fas fa-edit"></i> Editar
                            </a>
                            <a href="accommodation_delete.php?id=<?= htmlspecialchars($accommodation['id']) ?>" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este alojamiento?');">
                                <i class="fas fa-trash"></i> Eliminar
                            </a>
                            <!-- Botón para Servicios -->
                            <a href="accommodation_services.php?id=<?= htmlspecialchars($accommodation['id']) ?>" class="btn btn-info">
                                <i class="fas fa-concierge-bell"></i> Servicios
                            </a>
                            <!-- Botón para Fotos -->
                            <a href="accommodation_galleries.php?id=<?= htmlspecialchars($accommodation['id']) ?>" class="btn btn-success">
                                <i class="fas fa-image"></i> Fotos
                            </a>
                            <!-- Botón para Habitaciones -->
                            <a href="accommodation_rooms.php?id=<?= htmlspecialchars($accommodation['id']) ?>" class="btn btn-secondary">
                                <i class="fas fa-bed"></i> Habitaciones
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
