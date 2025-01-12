<?php 
include('navbar.php');
?>

<!-- Sección de Registro -->
<div class="container my-5">
    <h2 class="text-center mb-4">Crear una cuenta</h2>
    <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger text-center">
        <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
    <?php endif; ?>


    <p class="form-instructions">Por favor, completa el formulario para registrarte. Los campos marcados con un asterisco (*) son obligatorios.</p>

    <form action="../Controllers/registerHandler.php" method="POST" class="border p-4 rounded shadow-sm">
        <div class="row g-3">
            <div class="col-md-12">
                <label for="fullname" class="form-label required">Nombre Completo</label>
                <input type="text" class="form-control" id="fullname" name="fullname" maxlength='100' required>
            </div>
            <div class="col-md-12">
                <label for="address" class="form-label">Dirección</label>
                <textarea cols='2' type="text" class="form-control" id="address" name="address" maxlength='500'></textarea>
            </div>
            <div class="col-md-6">
                <label for="email" class="form-label required">Correo Electrónico</label>
                <input type="email" class="form-control" id="email" name="email" maxlength='250' required>
            </div>
            <div class="col-md-6">
                <label for="phone" class="form-label">Teléfono</label>
                <input type="text" class="form-control" id="phone" name="phone" maxlength='30'>
            </div>
            <div class="col-md-6">
                <label for="username" class="form-label required">Nombre de Usuario</label>
                <input type="text" class="form-control highlight-input" id="username" name="username" maxlength='100' required>
            </div>
            <div class="col-md-6">
                <label for="password" class="form-label required">Contraseña</label>
                <input type="password" class="form-control highlight-input" id="password" name="password" maxlength='100' required>
            </div>
            <div class="col-md-6">
                <label for="confirm_password" class="form-label required">Confirmar Contraseña</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" maxlength='100' required>
            </div>

            <div class="col-md-12">
                <label for="destination" class="form-label required">País de residencia</label>
                <select class="form-control form-select select2" id="destination" name="destination" required>
                    <!-- Los destinos se cargarán aquí -->
                </select>
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary form-button">Registrarse</button>
            </div>
        </div>
    </form>
</div>

<?php include('footer.php');?>
