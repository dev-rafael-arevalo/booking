<?php
require_once('../Helpers/jwt_helper.php');
require_once('../Controllers/ServiceController.php');
$serviceController = new ServiceController();

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

        // Comprobar si se ha enviado el formulario
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recoger los datos del formulario
            $name = $_POST['name'];
            $fa_icon = $_POST['fa_icon'];
            $type = $_POST['type'];
            $active =  1;

            // Validar que los datos no estén vacíos
            if (empty($name) || empty($fa_icon) || empty($type)) {
                echo "<div class='alert alert-danger'>Por favor, completa todos los campos.</div>";
            } else {
                // Crear el nuevo servicio
                $serviceController->store($name, $fa_icon, $type, $active, $userId);

                $mensaje= "Servicio creado con éxito.";
                // Redirigir después de crear (para evitar el reenvío del formulario)
                header("Location: service_list.php?mensaje='".$mensaje."'");
            }
        }
?>

<div class='row col-md-10 justify-content-between my-5'>
            <span class='col-md-6'>
                <h1 class='h1'>Crear nuevo servicio</h1>
            </span>
            <span class='col-md-2'>
                <a href="service_list.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver
                </a>
            </span>            
        </div>
        <form method="POST" action="service_create.php" class='row col-lg-10 col-md-10 justify-content-center was-validated'>
            <div class="row mb-3 col-lg-12 col-md-12">
                <label for="name" class="form-label required">Nombre del Servicio</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3 col-lg-6 col-md-6">
                    <label for="fa_icon" class="form-label required">Ícono (FontAwesome)</label>
                    <!-- Selector de iconos -->
                    <div class="input-group">
                        <input type="text" class="form-control" id="fa_icon" name="fa_icon" readonly placeholder="Selecciona un ícono" required>
                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#iconModal">
                            <i id="selectedIcon" class="fas fa-home"></i> Seleccionar
                        </button>
                    </div>
                    <small>Selecciona un ícono de FontAwesome.</small>
            </div>
            <div class="mb-3 col-lg-6 col-md-6">
                <label for="type" class="form-label required">Tipo</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="accommodation">Alojamiento</option>
                    <option value="room">Habitación</option>
                </select>
            </div>            
            <button type="submit" class="btn btn-primary col-1 mb-3">Crear Servicio</button>
        </form>
    </div>
    <div class="modal fade" id="iconModal" tabindex="-1" aria-labelledby="iconModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="iconModalLabel">Selecciona un ícono</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <?php
                                $icons = [
                                        'fa-home', 'fa-car', 'fa-bed', 'fa-laptop', 'fa-cogs', 'fa-phone', 'fa-cloud', 'fa-umbrella', 'fa-wifi',
                                        'fa-cogs', 'fa-tree', 'fa-mountain', 'fa-bicycle', 'fa-rocket', 'fa-sun', 'fa-moon', 'fa-heart', 'fa-star',
                                        'fa-users', 'fa-hospital', 'fa-briefcase', 'fa-camera', 'fa-globe', 'fa-book', 'fa-paint-brush', 'fa-dumbbell',
                                        'fa-bullhorn', 'fa-bullseye', 'fa-bus', 'fa-cab', 'fa-calculator', 'fa-calendar', 'fa-calendar-o', 'fa-calendar-check-o',
                                        'fa-calendar-minus-o', 'fa-calendar-plus-o', 'fa-calendar-times-o', 'fa-camera-retro', 'fa-car', 'fa-caret-square-o-down',
                                        'fa-caret-square-o-left', 'fa-caret-square-o-right', 'fa-caret-square-o-up', 'fa-cart-arrow-down', 'fa-cart-plus', 'fa-cc',
                                        'fa-certificate', 'fa-check', 'fa-check-circle', 'fa-check-circle-o', 'fa-check-square', 'fa-check-square-o', 'fa-child',
                                        'fa-circle', 'fa-circle-o', 'fa-circle-o-notch', 'fa-circle-thin', 'fa-clock-o', 'fa-clone', 'fa-close', 'fa-cloud',
                                        'fa-cloud-download', 'fa-cloud-upload', 'fa-code', 'fa-code-fork', 'fa-coffee', 'fa-cog', 'fa-cogs', 'fa-comment',
                                        'fa-comment-o', 'fa-comments', 'fa-comments-o', 'fa-commenting', 'fa-commenting-o', 'fa-compass', 'fa-copyright',
                                        'fa-credit-card', 'fa-credit-card-alt', 'fa-creative-commons', 'fa-crop', 'fa-crosshairs', 'fa-cube', 'fa-cubes',
                                        'fa-cutlery', 'fa-dashboard', 'fa-database', 'fa-deaf', 'fa-deafness', 'fa-desktop', 'fa-diamond', 'fa-dot-circle-o',
                                        'fa-download', 'fa-drivers-license', 'fa-drivers-license-o', 'fa-edit', 'fa-ellipsis-h', 'fa-ellipsis-v', 'fa-envelope',
                                        'fa-envelope-o', 'fa-envelope-open', 'fa-envelope-open-o', 'fa-envelope-square', 'fa-eraser', 'fa-exchange', 'fa-exclamation',
                                        'fa-exclamation-circle', 'fa-exclamation-triangle', 'fa-external-link', 'fa-external-link-square', 'fa-eye', 'fa-eye-slash',
                                        'fa-eyedropper', 'fa-fax', 'fa-female', 'fa-fighter-jet', 'fa-file-archive-o', 'fa-file-audio-o', 'fa-file-code-o',
                                        'fa-file-excel-o', 'fa-file-image-o', 'fa-file-movie-o', 'fa-file-pdf-o', 'fa-file-photo-o', 'fa-file-picture-o',
                                        'fa-file-powerpoint-o', 'fa-file-sound-o', 'fa-file-video-o', 'fa-file-word-o', 'fa-file-zip-o', 'fa-film', 'fa-filter',
                                        'fa-fire', 'fa-fire-extinguisher', 'fa-flag', 'fa-flag-checkered', 'fa-flag-o', 'fa-flash', 'fa-flask', 'fa-folder',
                                        'fa-folder-o', 'fa-folder-open', 'fa-folder-open-o', 'fa-frown-o', 'fa-futbol-o', 'fa-gamepad', 'fa-gavel', 'fa-gear',
                                        'fa-gears', 'fa-genderless', 'fa-gift', 'fa-glass', 'fa-globe', 'fa-graduation-cap', 'fa-group', 'fa-hard-of-hearing',
                                        'fa-hdd-o', 'fa-handshake-o', 'fa-hashtag', 'fa-headphones', 'fa-heart', 'fa-heart-o', 'fa-heartbeat', 'fa-history',
                                        'fa-home', 'fa-hotel', 'fa-hourglass', 'fa-hourglass-1', 'fa-hourglass-2', 'fa-hourglass-3', 'fa-hourglass-end',
                                        'fa-hourglass-half', 'fa-hourglass-o', 'fa-hourglass-start', 'fa-i-cursor', 'fa-id-badge', 'fa-id-card', 'fa-id-card-o',
                                        'fa-image', 'fa-inbox', 'fa-industry', 'fa-info', 'fa-info-circle', 'fa-institution', 'fa-key', 'fa-keyboard-o',
                                        'fa-language', 'fa-laptop', 'fa-leaf', 'fa-legal', 'fa-lemon-o', 'fa-level-down', 'fa-level-up', 'fa-life-bouy',
                                        'fa-life-buoy', 'fa-life-ring', 'fa-life-saver', 'fa-lightbulb-o', 'fa-line-chart', 'fa-location-arrow', 'fa-lock',
                                        'fa-low-vision', 'fa-magic', 'fa-magnet', 'fa-mail-forward', 'fa-mail-reply', 'fa-mail-reply-all', 'fa-male', 'fa-map',
                                        'fa-map-o', 'fa-map-pin', 'fa-map-signs', 'fa-map-marker', 'fa-meh-o', 'fa-microchip', 'fa-microphone', 'fa-microphone-slash',
                                        'fa-minus', 'fa-minus-circle', 'fa-minus-square', 'fa-minus-square-o', 'fa-mobile', 'fa-mobile-phone', 'fa-money',
                                        'fa-moon-o', 'fa-mortar-board', 'fa-motorcycle', 'fa-mouse-pointer', 'fa-music', 'fa-navicon', 'fa-newspaper-o',
                                        'fa-object-group', 'fa-object-ungroup', 'fa-paint-brush', 'fa-paper-plane', 'fa-paper-plane-o', 'fa-paw', 'fa-pencil',
                                        'fa-pencil-square', 'fa-pencil-square-o', 'fa-percent', 'fa-phone', 'fa-phone-square', 'fa-photo', 'fa-picture-o',
                                        'fa-pie-chart', 'fa-plane', 'fa-plug', 'fa-plus', 'fa-plus-circle', 'fa-plus-square', 'fa-plus-square-o', 'fa-podcast',
                                        'fa-power-off', 'fa-print', 'fa-puzzle-piece', 'fa-qrcode', 'fa-question', 'fa-question-circle', 'fa-question-circle-o',
                                        'fa-quote-left', 'fa-quote-right', 'fa-random', 'fa-recycle', 'fa-refresh', 'fa-registered', 'fa-remove', 'fa-reorder',
                                        'fa-reply', 'fa-reply-all', 'fa-retweet', 'fa-road', 'fa-rocket', 'fa-rss'
                                ];
                                foreach ($icons as $icon) {
                                    echo "<div class='col-3 text-center'>
                                        <button type='button' class='btn btn-outline-primary select-icon' data-icon='$icon'>
                                            <i class='fas $icon'></i><br>$icon
                                        </button>
                                    </div>";
                                }
                            ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
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
