<?php include('navbar.php'); ?>

<!-- Sección de Login -->
<div class="container my-5">
    <div class='row justify-content-center col-md-12'>
    <h2 class="text-center mb-4">Iniciar sesión</h2>    

    <?php if (isset($_GET['error'])) { ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($_GET['error']); ?>
        </div>
    <?php } ?>
    
    <form action="../Controllers/LoginHandler.php" method="POST" class="border p-4 rounded shadow-sm col-md-3" autocomplete='off'>
        <div class="row">
            <div class="col-md-12">
                <label for="username" class="form-label required">Nombre de Usuario</label>
                <input type="text" class="form-control" id="username" name="username" maxlength='100' required>
            </div>
            <div class="col-md-12">
                <label for="password" class="form-label required">Contraseña</label>
                <input type="password" class="form-control" id="password" name="password" maxlength='100' required>
            </div>
            <div class="col-md-12 text-center">
                <button type="submit" class="btn btn-primary form-button">Iniciar sesión</button>
            </div>
        </div>
    </form>
</div>
    </div>
<?php include('footer.php'); ?>
