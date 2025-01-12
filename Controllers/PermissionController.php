<?php
require_once('../Models/PermissionModel.php');
require_once('../Helpers/SessionHelper.php');
require_once('../Models/RoleModel.php');

class AuthController {
    private $permissionModel, $roleModel;
    

    public function __construct() {
        $this->permissionModel = new PermissionModel();
        $this->roleModel = new RoleModel();
    }

    // Cargar permisos del usuario y almacenarlos en sesión
    public function loadPermissionsForUser($roleId) {
        $permissions = $this->permissionModel->getPermissionsByRole($roleId);
        SessionHelper::set('permissions', $permissions);
    }

    // Verificar si el usuario tiene permiso para una acción
    public function checkPermission($roleId) {
        return $this->permissionModel->getPermissionsByModuleRole('User',$roleId);
    }

    public function checkRole($userId){
        $role = $this->permissionModel->getRoleByUser($userId);
    }

    public function getPermission($moduleName,$roleId){
        return $this->permissionModel->getPermissionsByModuleRole($moduleName,$_GET['id']);
    }

    public function getId(){
        return $this->permissionModel->getById($_GET['id']);
    }

            // Guardar un nuevo estados
            public function store($module, $role, $per_read, $per_create, $per_update, $per_delete, $per_filter, $per_report, $create_user) {                
                $permised=$this->permissionModel->getById($role);                
                if ($permised){
                    $result=$this->permissionModel->update($permised['id'], $module, $role, $per_read, $per_create, $per_update, $per_delete, $per_filter, $per_report, $create_user);
                }else{
                    $result=$this->permissionModel->create($module, $role, $per_read, $per_create, $per_update, $per_delete, $per_filter, $per_report, $create_user);
                }
                                
                if ($result) {
                    $mensaje = "Permiso actualizado con éxito.";
                    // Redirigir después de actualizar (para evitar el reenvío del formulario)
                    header("Location: roles_list.php?mensaje='" . $mensaje . "'");
                    exit();
                } else {
                    $mensaje = "Error al actualizar el estado.";
                    // Redirigir después de actualizar (para evitar el reenvío del formulario)
                    header("Location: roles_list.php?mensaje='" . $mensaje . "'");
                    exit();
                }
            }    
            
    
            
}
