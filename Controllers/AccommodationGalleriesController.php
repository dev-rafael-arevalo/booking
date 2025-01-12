<?php

require_once '../Models/AccommodationGalleriesModel.php';

class AccommodationGalleriesController {
    
    private $AccommodationGalleriesModel;

    public function __construct() {
        // Instanciar el modelo de AccommodationGalleries
        $this->AccommodationGalleriesModel = new AccommodationGalleriesModel();
    }

    // Listar todas las galerías del alojamiento
    public function index() {
        return $accommodationGalleries = $this->AccommodationGalleriesModel->getAll();
    }

    // Guardar una nueva galería del alojamiento
    public function store($id_accommodation, $url_photo, $description, $create_user) {
        $result = $this->AccommodationGalleriesModel->create($id_accommodation, $url_photo, $description, $create_user);
        if ($result) {
            $mensaje = "Galería del alojamiento creada con éxito.";
            // Redirigir después de la creación
            header("Location: accommodation_galleries_list.php?mensaje='" . $mensaje . "'");
            exit();
        } else {
            $mensaje = "Error al crear la galería del alojamiento.";
            // Redirigir después de un error
            header("Location: accommodation_galleries_list.php?mensaje='" . $mensaje . "'");
            exit();
        }
    }

    // Obtener una galería del alojamiento por ID
    public function getId($id) {
        return $this->AccommodationGalleriesModel->getById($id);
    }

    // Actualizar una galería del alojamiento
    public function update($id, $id_accommodation, $url_photo, $description, $active, $modified_user) {
        $result = $this->AccommodationGalleriesModel->update($id, $id_accommodation, $url_photo, $description, $active, $modified_user);
        if ($result) {
            $mensaje = "Galería del alojamiento actualizada con éxito.";
            // Redirigir después de la actualización
            header("Location: accommodation_galleries_list.php?mensaje='" . $mensaje . "'");
        } else {
            $mensaje = "Error al actualizar la galería del alojamiento.";
            // Redirigir después de un error
            header("Location: accommodation_galleries_list.php?mensaje='" . $mensaje . "'");
        }
    }

    // Eliminar una galería del alojamiento (desactivación lógica)
    public function delete($id, $modified_user) {
        $result = $this->AccommodationGalleriesModel->delete($id, $modified_user);
        if ($result) {
            $mensaje = "Galería del alojamiento eliminada con éxito.";
            // Redirigir después de la eliminación
            header("Location: accommodation_galleries_list.php?mensaje='" . $mensaje . "'");
        } else {
            $mensaje = "Error al eliminar la galería del alojamiento.";
            // Redirigir después de un error
            header("Location: accommodation_galleries_list.php?mensaje='" . $mensaje . "'");
        }
    }
}

?>
