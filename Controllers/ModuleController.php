<?php
require_once('../Models/ModuleModel.php');

class ModuleController {
    private $ModulesModel;

    public function __construct() {
        $this->ModulesModel = new ModuleModel();
    }

    public function getModule($moduleId) {
        $permissions = $this->ModulesModel->getModules($moduleId);
        
    }

    public function getAll() {
        return $this->ModulesModel->getAll();
        
    }
        // Listar todos los estados
        public function index() {
            return $Modules = $this->ModulesModel->getAll();
        }
    
        // Guardar un nuevo estados
        public function store($name, $create_user) {
            $result = $this->ModulesModel->create($name,$create_user);
            if ($result) {
                $mensaje = "Modulo creado con éxito.";
                // Redirigir después de actualizar (para evitar el reenvío del formulario)
                header("Location: modules_list.php?mensaje='" . $mensaje . "'");
                exit();
            } else {
                $mensaje = "Error al actualizar el estado.";
                // Redirigir después de actualizar (para evitar el reenvío del formulario)
                header("Location: modules_list.php?mensaje='" . $mensaje . "'");
                exit();
            }
        }
    
        // Obtener un estados por ID
        public function getId($id) {
            return $this->ModulesModel->getById($id);
        }
    
        // Actualizar un estado
        public function update($id, $name, $active, $modified_user) {
            $result = $this->ModulesModel->update($id, $name, $active, $modified_user);
            if ($result) {
                $mensaje = "Modulo actualizado con éxito.";
                // Redirigir después de actualizar (para evitar el reenvío del formulario)
                header("Location: modules_list.php?mensaje='" . $mensaje . "'");
            } else {
                $mensaje = "Error al guardar el estado.";
                // Redirigir después de actualizar (para evitar el reenvío del formulario)
                header("Location: modules_list.php?mensaje='" . $mensaje . "'");
            }
        }
    
        // Eliminar un estado (desactivación lógica)
        public function delete($id, $modified_user) {
            $result = $this->ModulesModel->delete($id, $modified_user);
            if ($result) {
                $mensaje = "Modulo eliminado.";
                // Redirigir después de actualizar (para evitar el reenvío del formulario)
                header("Location: modules_list.php?mensaje=" . $mensaje );
            } else {
                $mensaje = "Error al eliminar el estado.";
                // Redirigir después de actualizar (para evitar el reenvío del formulario)
                header("Location: modules_list.php?mensaje='" . $mensaje . "'");
            }
        }
        
    
}
