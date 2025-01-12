<?php

require_once '../Models/BookingsModel.php';

class BookingsController {
    
    private $BookingsModel;

    public function __construct() {
        // Instanciar el modelo de Bookings
        $this->BookingsModel = new BookingsModel();
    }

    // Listar todas las reservas
    public function index() {
        return $bookings = $this->BookingsModel->getAll();
    }

    // Guardar una nueva reserva
    public function store($id_accommodation_room, $id_user, $id_status, $check_in, $check_out, $comments, $create_user) {
        $result = $this->BookingsModel->create($id_accommodation_room, $id_user, $id_status, $check_in, $check_out, $comments, $create_user);
        if ($result) {
            $mensaje = "Reserva creada con éxito.";
            // Redirigir después de la creación
            header("Location: bookings_list.php?mensaje='" . $mensaje . "'");
            exit();
        } else {
            $mensaje = "Error al crear la reserva.";
            // Redirigir después de un error
            header("Location: bookings_list.php?mensaje='" . $mensaje . "'");
            exit();
        }
    }

    // Obtener una reserva por ID
    public function getId($id) {
        return $this->BookingsModel->getById($id);
    }

    // Actualizar una reserva
    public function update($id, $id_accommodation_room, $id_user, $id_status, $check_in, $check_out, $comments, $modified_user) {
        $result = $this->BookingsModel->update($id, $id_accommodation_room, $id_user, $id_status, $check_in, $check_out, $comments, $modified_user);
        if ($result) {
            $mensaje = "Reserva actualizada con éxito.";
            // Redirigir después de la actualización
            header("Location: bookings_list.php?mensaje='" . $mensaje . "'");
        } else {
            $mensaje = "Error al actualizar la reserva.";
            // Redirigir después de un error
            header("Location: bookings_list.php?mensaje='" . $mensaje . "'");
        }
    }

    // Eliminar una reserva (desactivación lógica)
    public function delete($id, $modified_user) {
        $result = $this->BookingsModel->delete($id, $modified_user);
        if ($result) {
            $mensaje = "Reserva eliminada con éxito.";
            // Redirigir después de la eliminación
            header("Location: bookings_list.php?mensaje='" . $mensaje . "'");
        } else {
            $mensaje = "Error al eliminar la reserva.";
            // Redirigir después de un error
            header("Location: bookings_list.php?mensaje='" . $mensaje . "'");
        }
    }
}

?>
