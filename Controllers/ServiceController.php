<?php

require_once '../Models/ServiceModel.php';

class ServiceController {
    
    private $serviceModel;

    public function __construct() {
        // Instanciar el modelo de Usuario
        $this->serviceModel = new ServiceModel();
    }

    // Listar todos los servicios
    public function index() {
        return $services = $this->serviceModel->getAll();
    }

    // Mostrar el formulario para crear un nuevo servicio
    public function createForm() {
        include '../views/services/service_create.php';
    }

    // Guardar un nuevo servicio
    public function store($name, $fa_icon, $type, $create_user) {
        $result = $this->serviceModel->create($name, $fa_icon, $type, $create_user);
        if ($result) {
            header('Location: service_list.php'); // Redirige al listado después de guardar
         } else {
             return $mensaje= "Error al guardar el servicio.";
         }
    }

    // Obtener un servicio por ID
    public function getId($id) {
        return $this->serviceModel->getById($id);
    }

    // Actualizar un servicio
    public function update($id, $name, $fa_icon, $type, $active, $modified_user) {
        $result = $this->serviceModel->update($id, $name, $fa_icon, $type, $active, $modified_user);
        if ($result) {
            header('Location: service_list.php'); // Redirige al listado después de guardar
        } else {
            echo "Error al guardar el servicio.";
        }
    }

    // Eliminar un servicio (desactivación lógica)
    public function delete($id, $modified_user) {
        $result = $this->serviceModel->delete($id, $modified_user);
        if ($result) {
            header('Location: ../views/services/service_list.php'); // Redirige al listado después de eliminar
        } else {
            echo "Error al eliminar el servicio.";
        }
    }
}

?>
