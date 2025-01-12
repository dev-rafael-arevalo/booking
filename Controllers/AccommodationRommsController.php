<?php

require_once '../Models/AccommodationRoomsModel.php';

class AccommodationRoomsController {
    
    private $AccommodationRoomsModel;

    public function __construct() {
        // Instanciar el modelo de AccommodationRooms
        $this->AccommodationRoomsModel = new AccommodationRoomsModel();
    }

    // Listar todas las habitaciones del alojamiento
    public function index() {
        return $accommodationRooms = $this->AccommodationRoomsModel->getAll();
    }

    // Guardar una nueva habitación del alojamiento
    public function store($id_accommodation, $bed_type, $max_host, $room_number, $description, $create_user) {
        $result = $this->AccommodationRoomsModel->create($id_accommodation, $bed_type, $max_host, $room_number, $description, $create_user);
        if ($result) {
            $mensaje = "Habitación del alojamiento creada con éxito.";
            // Redirigir después de la creación
            header("Location: accommodation_rooms_list.php?mensaje='" . $mensaje . "'");
            exit();
        } else {
            $mensaje = "Error al crear la habitación del alojamiento.";
            // Redirigir después de un error
            header("Location: accommodation_rooms_list.php?mensaje='" . $mensaje . "'");
            exit();
        }
    }

    // Obtener una habitación del alojamiento por ID
    public function getId($id) {
        return $this->AccommodationRoomsModel->getById($id);
    }

    // Actualizar una habitación del alojamiento
    public function update($id, $id_accommodation, $bed_type, $max_host, $room_number, $description, $active, $modified_user) {
        $result = $this->AccommodationRoomsModel->update($id, $id_accommodation, $bed_type, $max_host, $room_number, $description, $active, $modified_user);
        if ($result) {
            $mensaje = "Habitación del alojamiento actualizada con éxito.";
            // Redirigir después de la actualización
            header("Location: accommodation_rooms_list.php?mensaje='" . $mensaje . "'");
        } else {
            $mensaje = "Error al actualizar la habitación del alojamiento.";
            // Redirigir después de un error
            header("Location: accommodation_rooms_list.php?mensaje='" . $mensaje . "'");
        }
    }

    // Eliminar una habitación del alojamiento (desactivación lógica)
    public function delete($id, $modified_user) {
        $result = $this->AccommodationRoomsModel->delete($id, $modified_user);
        if ($result) {
            $mensaje = "Habitación del alojamiento eliminada con éxito.";
            // Redirigir después de la eliminación
            header("Location: accommodation_rooms_list.php?mensaje='" . $mensaje . "'");
        } else {
            $mensaje = "Error al eliminar la habitación del alojamiento.";
            // Redirigir después de un error
            header("Location: accommodation_rooms_list.php?mensaje='" . $mensaje . "'");
        }
    }
}

?>
