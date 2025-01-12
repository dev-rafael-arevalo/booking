<?php
require_once('../Helpers/jwt_helper.php');
require_once('../Controllers/PermissionController.php');
require_once('../Controllers/ModuleController.php');
$permissionController = new AuthController();
$moduleController = new ModuleController();


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

        if ($permissionController->checkPermission($payload['roleId'])){

        $moduleAll = $moduleController->getAll();       
        

        // El usuario está autenticado, puedes acceder a $payload['userId'] aquí
        $userId = $payload['userId'];
        $login = $payload['login'];
        

        // Verificar si el ID del servicio es válido
        if (isset($_GET['id'])) {
            $rolesId = $_GET['id'];
            $permission = $permissionController->getId($rolesId); // Obtener servicio a editar
        }

        // Comprobar si se ha enviado el formulario
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Recoger los datos del formulario                        
            $active = 1;

            foreach($moduleAll as $row) { 
                $idModule = $_POST['idModule'.$row['id']];   
                $idRole = $_POST['idRole'.$row['id']];
                $perm=$permissionController->getPermission($row['name'],$idRole);
                $per_read = isset($_POST['per_read' . $row['id']]) && $_POST['per_read' . $row['id']] === 'on' ? 1 : 0;
                $per_create = isset($_POST['per_create' . $row['id']]) && $_POST['per_create' . $row['id']] === 'on' ? 1 : 0;
                $per_update = isset($_POST['per_update' . $row['id']]) && $_POST['per_update' . $row['id']] === 'on' ? 1 : 0;
                $per_delete = isset($_POST['per_delete' . $row['id']]) && $_POST['per_delete' . $row['id']] === 'on' ? 1 : 0;
                $per_filter = isset($_POST['per_filter' . $row['id']]) && $_POST['per_filter' . $row['id']] === 'on' ? 1 : 0;
                $per_report = isset($_POST['per_report' . $row['id']]) && $_POST['per_report' . $row['id']] === 'on' ? 1 : 0;

                if($perm){            
                    // Actualizar el servicio
                    $permissionController->store($idModule, $idRole, $per_read, $per_create, $per_update, $per_delete, $per_filter, $per_report, $login);  
                    
                }
                $mensaje='Permisos actualizados con éxito';

            }
          
        }
        include('navbar.php'); // Incluir la barra de navegación
?>

<div class='row col-md-10 justify-content-between my-5'>
    <span class='col-md-6'>
        <h1 class='h1'>Editar Permisos</h1>
        <h2 class='h2'>Rol: <span class='text-info'><?php echo $permissionController->getId()['name_role'];?></span></h2>
    </span>
    <span class='col-md-2'>
        <a href="roles_list.php" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </span>
</div>

<form method="POST" action="permission_edit.php?id=<?php echo $rolesId; ?>" class='row col-lg-10 col-md-10 justify-content-center was-validated'>
    <div class="row mb-3 col-lg-12 col-md-12">        
        <table id="permissionTable" name="permissionTable" class='table table-stripped'> 
            <thead>
                <tr class='bg bg-primary text-center text-white'>
                <th>Módulo</th>
                <th>Leer</th>
                <th>Crear</th>
                <th>Actualizar</th>
                <th>Eliminar</th>
                <th>Filtrar</th>
                <th>Ver reportes</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($moduleAll as $row) { 
                $permissionValue=[];
                $permissions = $permissionController->getPermission($row['name'],$payload['roleId']);        
                if ($permissions){
                    foreach($permissions as $row2){
                        array_push($permissionValue,$row2['per_read']
                        ,$row2['per_create'],$row2['per_update'],$row2['per_delete'],$row2['per_filter'],$row2['per_report']);
                    }
                }  else {
                    $permissionValue=[0,0,0,0,0,0,0];  
                }              
                ?>
                <tr>
                <td><input type='hidden' id='idModule<?php echo $row['id'];?>' name='idModule<?php echo $row['id'];?>' value='<?php echo htmlspecialchars($row['id']); ?>'><input type='hidden' id='idRole<?php echo $row['id'];?>' name='idRole<?php echo $row['id'];?>' value='<?php echo $_GET['id'];?>'><?php echo htmlspecialchars($row['name']); ?>
                </td>
                <td class='text-center'><input type='checkbox' id='per_read<?php echo $row['id'];?>' name='per_read<?php echo $row['id'];?>' class='form-checkbox' <?php if ($permissionValue[0]==1) { echo 'checked'; } ?>></td>
                <td class='text-center'><input type='checkbox' id='per_create<?php echo $row['id'];?>' name='per_create<?php echo $row['id'];?>' class='form-checkbox' <?php if ($permissionValue[1]==1) { echo 'checked'; } ?>></td>
                <td class='text-center'><input type='checkbox' id='per_update<?php echo $row['id'];?>' name='per_update<?php echo $row['id'];?>' class='form-checkbox' <?php if ($permissionValue[2]==1) { echo 'checked'; } ?>></td>
                <td class='text-center'><input type='checkbox' id='per_delete<?php echo $row['id'];?>' name='per_delete<?php echo $row['id'];?>' class='form-checkbox' <?php if ($permissionValue[3]==1) { echo 'checked'; } ?>></td>
                <td class='text-center'><input type='checkbox' id='per_filter<?php echo $row['id'];?>' name='per_filter<?php echo $row['id'];?>' class='form-checkbox' <?php if ($permissionValue[4]==1) { echo 'checked'; } ?>></td>
                <td class='text-center'><input type='checkbox' id='per_report<?php echo $row['id'];?>' name='per_report<?php echo $row['id'];?>' class='form-checkbox' <?php if ($permissionValue[5]==1) { echo 'checked'; } ?>></td>
                </tr>
            <?php } ?>
            </tbody>
        </table>

    </div>     
    <div class="row col-lg-6 col-md-6">
        <label for="boton" class="form-label">&nbsp;</label>
        <button id='boton' name='boton' type="submit" class="btn btn-primary col-3">Actualizar Permisos</button>
    </div>
</form>
</div>
<?php
    } else {    
        header("Location: ../views/login_form.php?error=Error (402) No estás autorizado a entrar a la página de edición de permisos");
    }
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Error: " . $e->getMessage() . "</div>";
    }

} else {    
    header("Location: ../views/login_form.php?error=La sesión se ha cerrado");
}
?>
