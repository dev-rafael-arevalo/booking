<?php

require_once '../Models/AccommodationServicesModel.php';

class AccommodationServicesController {
    
    private $AccommodationServicesModel;

    public function __construct() {
        // Instanciar el modelo de AccommodationServices
        $this->AccommodationServicesModel = new AccommodationServicesModel();
    }

    // Listar todos los servicios del alojamiento
    public function index() {
        return $accommodationServices = $this->AccommodationServicesModel->getAll();
    }

    // Guardar un nuevo servicio del alojamiento
    public function store($id_service, $id_accommodation, $create_user) {
        $result = $this->AccommodationServicesModel->create($id_service, $id_accommodation, $create_user);
        if ($result) {
            $mensaje = "Servicio del alojamiento creado con éxito.";
            // Redirigir después de la creación
            header("Location: accommodation_services_list.php?mensaje='" . $mensaje . "'");
            exit();
        } else {
            $mensaje = "Error al crear el servicio del alojamiento.";
            // Redirigir después de un error
            header("Location: accommodation_services_list.php?mensaje='" . $mensaje . "'");
            exit();
        }
    }

    // Obtener un servicio del alojamiento por ID
    public function getId($id) {
        return $this->AccommodationServicesModel->getById($id);
    }

    // Actualizar un servicio del alojamiento
    public function update($id, $id_service, $id_accommodation, $active, $modified_user) {
        $result = $this->AccommodationServicesModel->update($id, $id_service, $id_accommodation, $active, $modified_user);
        if ($result) {
            $mensaje = "Servicio del alojamiento actualizado con éxito.";
            // Redirigir después de la actualización
            header("Location: accommodation_services_list.php?mensaje='" . $mensaje . "'");
        } else {
            $mensaje = "Error al actualizar el servicio del alojamiento.";
            // Redirigir después de un error
            header("Location: accommodation_services_list.php?mensaje='" . $mensaje . "'");
        }
    }

    // Eliminar un servicio del alojamiento (desactivación lógica)
    public function delete($id, $modified_user) {
        $result = $this->AccommodationServicesModel->delete($id, $modified_user);
        if ($result) {
            $mensaje = "Servicio del alojamiento eliminado con éxito.";
            // Redirigir después de la eliminación
            header("Location: accommodation_services_list.php?mensaje='" . $mensaje . "'");
        } else {
            $mensaje = "Error al eliminar el servicio del alojamiento.";
            // Redirigir después de un error
            header("Location: accommodation_services_list.php?mensaje='" . $mensaje . "'");
        }
    }
}

?>
