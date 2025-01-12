<?php

require_once '../Models/AccommodationsModel.php';

class AccommodationsController {
    
    private $AccommodationsModel;

    public function __construct() {
        // Instanciar el modelo de Accommodations
        $this->AccommodationsModel = new AccommodationsModel();
    }

    // Listar todos los alojamientos
    public function index() {
        return $accommodations = $this->AccommodationsModel->getAll();
    }

    // Guardar un nuevo alojamiento
    public function store($id_user, $name, $address, $email_contact, $phone, $iso_country, $description, $create_user) {
        $result = $this->AccommodationsModel->create($id_user, $name, $address, $email_contact, $phone, $iso_country, $description, $create_user);
        if ($result) {
            $mensaje = "Alojamiento creado con éxito.";
            // Redirigir después de la creación
            header("Location: accommodations_list.php?mensaje='" . $mensaje . "'");
            exit();
        } else {
            $mensaje = "Error al crear el alojamiento.";
            // Redirigir después de un error
            header("Location: accommodations_list.php?mensaje='" . $mensaje . "'");
            exit();
        }
    }

    // Obtener un alojamiento por ID
    public function getId($id) {
        return $this->AccommodationsModel->getById($id);
    }

    // Actualizar un alojamiento
    public function update($id, $id_user, $name, $address, $email_contact, $phone, $iso_country, $description, $active, $modified_user) {
        $result = $this->AccommodationsModel->update($id, $id_user, $name, $address, $email_contact, $phone, $iso_country, $description, $active, $modified_user);
        if ($result) {
            $mensaje = "Alojamiento actualizado con éxito.";
            // Redirigir después de la actualización
            header("Location: accommodations_list.php?mensaje='" . $mensaje . "'");
        } else {
            $mensaje = "Error al actualizar el alojamiento.";
            // Redirigir después de un error
            header("Location: accommodations_list.php?mensaje='" . $mensaje . "'");
        }
    }

    // Eliminar un alojamiento (desactivación lógica)
    public function delete($id, $modified_user) {
        $result = $this->AccommodationsModel->delete($id, $modified_user);
        if ($result) {
            $mensaje = "Alojamiento eliminado con éxito.";
            // Redirigir después de la eliminación
            header("Location: accommodations_list.php?mensaje='" . $mensaje . "'");
        } else {
            $mensaje = "Error al eliminar el alojamiento.";
            // Redirigir después de un error
            header("Location: accommodations_list.php?mensaje='" . $mensaje . "'");
        }
    }
}

?>
