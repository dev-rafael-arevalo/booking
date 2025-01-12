<?php

require_once('../config/database.php');

class AccommodationGalleriesModel {
    private $conn;

    public function __construct() {
        $this->conn = getDatabaseConnection();

        if ($this->conn === null) {
            die("No se pudo establecer la conexión con la base de datos.");
        }
    }

    // Obtener todas las fotos activas de la galería
    public function getAll() {
        $query = "SELECT * FROM AccommodationGalleries WHERE active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una foto por ID
    public function getById($id) {
        $query = "SELECT * FROM AccommodationGalleries WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener todas las fotos de un alojamiento específico
    public function getByAccommodationId($id_accommodation) {
        $query = "SELECT * FROM AccommodationGalleries WHERE id_accommodation = :id_accommodation AND active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_accommodation', $id_accommodation, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insertar una nueva foto en la galería
    public function create($id_accommodation, $url_photo, $description, $create_user) {
        $query = "INSERT INTO AccommodationGalleries (id_accommodation, url_photo, description, active, create_user, create_date) 
                  VALUES (:id_accommodation, :url_photo, :description, 1, :create_user, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_accommodation', $id_accommodation, PDO::PARAM_INT);
        $stmt->bindParam(':url_photo', $url_photo);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':create_user', $create_user);
        return $stmt->execute();
    }

    // Actualizar los datos de una foto
    public function update($id, $id_accommodation, $url_photo, $description, $active, $modified_user) {
        $query = "UPDATE AccommodationGalleries 
                  SET id_accommodation = :id_accommodation, url_photo = :url_photo, description = :description, 
                      active = :active, modified_user = :modified_user, modified_date = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':id_accommodation', $id_accommodation, PDO::PARAM_INT);
        $stmt->bindParam(':url_photo', $url_photo);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':active', $active, PDO::PARAM_BOOL);
        $stmt->bindParam(':modified_user', $modified_user);
        return $stmt->execute();
    }

    // Eliminar una foto de la galería (desactivación lógica)
    public function delete($id, $modified_user) {
        $query = "UPDATE AccommodationGalleries 
                  SET active = 0, modified_user = :modified_user, modified_date = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':modified_user', $modified_user);
        return $stmt->execute();
    }
}
