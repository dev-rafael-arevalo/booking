<?php
require_once('../Models/RoleModel.php');

class RoleController {
    private $RolesModel;

    public function __construct() {
        $this->RolesModel = new RoleModel();
    }

    public function getRole($roleId) {
        $permissions = $this->RolesModel->getRoles($roleId);
        
    }
        // Listar todos los estados
        public function index() {
            return $Roles = $this->RolesModel->getAll();
        }
    
        // Guardar un nuevo estados
        public function store($name, $create_user) {
            $result = $this->RolesModel->create($name,$create_user);
            if ($result) {
                $mensaje = "Rol creado con éxito.";
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
    
        // Obtener un estados por ID
        public function getId($id) {
            return $this->RolesModel->getById($id);
        }
    
        // Actualizar un estado
        public function update($id, $name, $active, $modified_user) {
            $result = $this->RolesModel->update($id, $name, $active, $modified_user);
            if ($result) {
                $mensaje = "Rol actualizado con éxito.";
                // Redirigir después de actualizar (para evitar el reenvío del formulario)
                header("Location: roles_list.php?mensaje='" . $mensaje . "'");
            } else {
                $mensaje = "Error al guardar el estado.";
                // Redirigir después de actualizar (para evitar el reenvío del formulario)
                header("Location: roles_list.php?mensaje='" . $mensaje . "'");
            }
        }
    
        // Eliminar un estado (desactivación lógica)
        public function delete($id, $modified_user) {
            $result = $this->RolesModel->delete($id, $modified_user);
            if ($result) {
                $mensaje = "Rol eliminado.";
                // Redirigir después de actualizar (para evitar el reenvío del formulario)
                header("Location: roles_list.php?mensaje=" . $mensaje );
            } else {
                $mensaje = "Error al eliminar el estado.";
                // Redirigir después de actualizar (para evitar el reenvío del formulario)
                header("Location: roles_list.php?mensaje='" . $mensaje . "'");
            }
        }
        
    
}
