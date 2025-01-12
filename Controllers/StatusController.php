<?php

require_once '../Models/StatusModel.php';

class StatusController {
    
    private $StatusModel;

    public function __construct() {
        // Instanciar el modelo de Status
        $this->StatusModel = new StatusModel();
    }

    // Listar todos los estados
    public function index() {
        return $Status = $this->StatusModel->getAll();
    }

    // Guardar un nuevo estados
    public function store($name, $create_user) {
        $result = $this->StatusModel->create($name,$create_user);
        if ($result) {
            $mensaje = "Estado creado con éxito.";
            // Redirigir después de actualizar (para evitar el reenvío del formulario)
            header("Location: status_list.php?mensaje='" . $mensaje . "'");
            exit();
        } else {
            $mensaje = "Error al actualizar el estado.";
            // Redirigir después de actualizar (para evitar el reenvío del formulario)
            header("Location: status_list.php?mensaje='" . $mensaje . "'");
            exit();
        }
    }

    // Obtener un estados por ID
    public function getId($id) {
        return $this->StatusModel->getById($id);
    }

    // Actualizar un estado
    public function update($id, $name, $active, $modified_user) {
        $result = $this->StatusModel->update($id, $name, $active, $modified_user);
        if ($result) {
            $mensaje = "Estado actualizado con éxito.";
            // Redirigir después de actualizar (para evitar el reenvío del formulario)
            header("Location: status_list.php?mensaje='" . $mensaje . "'");
        } else {
            $mensaje = "Error al guardar el estado.";
            // Redirigir después de actualizar (para evitar el reenvío del formulario)
            header("Location: status_list.php?mensaje='" . $mensaje . "'");
        }
    }

    // Eliminar un estado (desactivación lógica)
    public function delete($id, $modified_user) {
        $result = $this->StatusModel->delete($id, $modified_user);
        if ($result) {
            $mensaje = "Estado de la reserva eliminada.";
            // Redirigir después de actualizar (para evitar el reenvío del formulario)
            header("Location: status_list.php?mensaje='" . $mensaje . "'");
        } else {
            $mensaje = "Error al eliminar el estado.";
            // Redirigir después de actualizar (para evitar el reenvío del formulario)
            header("Location: status_list.php?mensaje='" . $mensaje . "'");
        }
    }
}

?>
