<?php
require_once('../Helpers/jwt_helper.php');
require_once('../Controllers/PermissionHandler.php');

$permissionHandler = new PermissionHandler();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lugarcitos.com</title>
    <!-- Bootstrap y otros estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">    
    <link href="https://cdn.datatables.net/v/bs5/dt-2.1.8/datatables.min.css" rel="stylesheet">    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="../assets/css/custom.css" rel="stylesheet" />
</head>
<body>
<div class='container-fluid'>
    <!-- Barra de navegación -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary" style="position: relative; z-index: 1000;">
        <div class="container-fluid">
            <a class="navbar-brand fw-bolder shadow" href="/booking">Lugarcitos.com</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <i class='bi bi-currency'></i><a class="nav-link" href="#">Moneda: United States Dollar</a>
                    </li>

                    <?php if ($permissionHandler->isLoggedIn()) { ?>
                        <!-- Opciones visibles para usuarios autenticados -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class='bi bi-gear'></i> Configuración
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="servicesDropdown">                                
                            <?php if ($permissionHandler->getUserRole()==1) { ?>
                                <li><a class="dropdown-item fw-bolder"><i class='fa fa-key'></i>&nbsp;SEGURIDAD</a></li>                            
                                <li><a class="dropdown-item" href="module_list.php">Módulos</a></li>                                
                                <li><a class="dropdown-item" href="roles_list.php">Roles</a></li>
                                <li><a class="dropdown-item" href="/activities">Usuarios</a></li>
                                <li><a class="dropdown-item fw-bolder"><i class='fa fa-cogs'></i>&nbsp;CONFIGURACIÓN</a></li>                            
                                <li><a class="dropdown-item" href="status_list.php">Estados de la reserva</a></li>
                                <hr>
                                <li><a class="dropdown-item fw-bolder"><i class='fa fa-home'></i>&nbsp;ALOJAMIENTOS</a></li>
                                <li><a class="dropdown-item" href="service_list.php">Servicios</a></li>
                                <li><a class="dropdown-item" href="accommodation_list.php">Mis alojamientos</a></li>                            
                                <li><a class="dropdown-item" href="/destinations">Reservas</a></li>  
                            <?php } else { ?>
                                <li><a class="dropdown-item" href="accommodation_list.php">Mis alojamientos</a></li>                            
                                <li><a class="dropdown-item" href="/destinations">Reservas</a></li>  
                            <?php } ?>
                            </ul>
                        </li>

                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Mi Cuenta
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="profile.php">Perfil</a></li>
                                <li><a class="dropdown-item" href="my_bookings.php">Mis Reservas</a></li>
                                <li><a class="dropdown-item" href="logout.php">Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    <?php } else { ?>
                        <!-- Opciones para invitados -->
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Crea tu cuenta</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login_form.php">Iniciar Sesión</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </nav>
<div class='row justify-content-center col-lg-12 col-md-12 col-sm-12 animate__animated animate__bounceInUp'>