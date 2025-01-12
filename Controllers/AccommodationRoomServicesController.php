<?php

require_once '../Models/AccommodationRoomServicesModel.php';

class AccommodationRoomServicesController {
    
    private $AccommodationRoomServicesModel;

    public function __construct() {
        // Instanciar el modelo de AccommodationRoomServices
        $this->AccommodationRoomServicesModel = new AccommodationRoomServicesModel();
    }

    // Listar todos los servicios de habitaciones del alojamiento
    public function index() {
        return $accommodationRoomServices = $this->AccommodationRoomServicesModel->getAll();
    }

    // Guardar un nuevo servicio de habitación del alojamiento
    public function store($id_accommodation, $id_service, $create_user) {
        $result = $this->AccommodationRoomServicesModel->create($id_accommodation, $id_service, $create_user);
        if ($result) {
            $mensaje = "Servicio de habitación del alojamiento creado con éxito.";
            // Redirigir después de la creación
            header("Location: accommodation_room_services_list.php?mensaje='" . $mensaje . "'");
            exit();
        } else {
            $mensaje = "Error al crear el servicio de habitación del alojamiento.";
            // Redirigir después de un error
            header("Location: accommodation_room_services_list.php?mensaje='" . $mensaje . "'");
            exit();
        }
    }

    // Obtener un servicio de habitación del alojamiento por ID
    public function getId($id) {
        return $this->AccommodationRoomServicesModel->getById($id);
    }

    // Actualizar un servicio de habitación del alojamiento
    public function update($id, $id_accommodation, $id_service, $active, $modified_user) {
        $result = $this->AccommodationRoomServicesModel->update($id, $id_accommodation, $id_service, $active, $modified_user);
        if ($result) {
            $mensaje = "Servicio de habitación del alojamiento actualizado con éxito.";
            // Redirigir después de la actualización
            header("Location: accommodation_room_services_list.php?mensaje='" . $mensaje . "'");
        } else {
            $mensaje = "Error al actualizar el servicio de habitación del alojamiento.";
            // Redirigir después de un error
            header("Location: accommodation_room_services_list.php?mensaje='" . $mensaje . "'");
        }
    }

    // Eliminar un servicio de habitación del alojamiento (desactivación lógica)
    public function delete($id, $modified_user) {
        $result = $this->AccommodationRoomServicesModel->delete($id, $modified_user);
        if ($result) {
            $mensaje = "Servicio de habitación del alojamiento eliminado con éxito.";
            // Redirigir después de la eliminación
            header("Location: accommodation_room_services_list.php?mensaje='" . $mensaje . "'");
        } else {
            $mensaje = "Error al eliminar el servicio de habitación del alojamiento.";
            // Redirigir después de un error
            header("Location: accommodation_room_services_list.php?mensaje='" . $mensaje . "'");
        }
    }
}

?>
