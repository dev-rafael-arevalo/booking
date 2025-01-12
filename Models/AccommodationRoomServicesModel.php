<?php

require_once('../config/database.php');

class AccommodationRoomServicesModel {
    private $conn;

    public function __construct() {
        $this->conn = getDatabaseConnection();

        if ($this->conn === null) {
            die("No se pudo establecer la conexión con la base de datos.");
        }
    }

    // Obtener todos los servicios de habitación activos
    public function getAll() {
        $query = "SELECT * FROM AccommodationRoomServices WHERE active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un servicio de habitación por ID
    public function getById($id) {
        $query = "SELECT * FROM AccommodationRoomServices WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener todos los servicios de habitación para un alojamiento específico
    public function getByAccommodationId($id_accommodation) {
        $query = "SELECT * FROM AccommodationRoomServices WHERE id_accommodation = :id_accommodation AND active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_accommodation', $id_accommodation, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear un nuevo servicio de habitación
    public function create($id_accommodation, $id_service, $create_user) {
        $query = "INSERT INTO AccommodationRoomServices (id_accommodation, id_service, active, create_user, create_date) 
                  VALUES (:id_accommodation, :id_service, 1, :create_user, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_accommodation', $id_accommodation, PDO::PARAM_INT);
        $stmt->bindParam(':id_service', $id_service, PDO::PARAM_INT);
        $stmt->bindParam(':create_user', $create_user);
        return $stmt->execute();
    }

    // Actualizar un servicio de habitación
    public function update($id, $id_accommodation, $id_service, $active, $modified_user) {
        $query = "UPDATE AccommodationRoomServices 
                  SET id_accommodation = :id_accommodation, id_service = :id_service, 
                      active = :active, modified_user = :modified_user, modified_date = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':id_accommodation', $id_accommodation, PDO::PARAM_INT);
        $stmt->bindParam(':id_service', $id_service, PDO::PARAM_INT);
        $stmt->bindParam(':active', $active, PDO::PARAM_BOOL);
        $stmt->bindParam(':modified_user', $modified_user);
        return $stmt->execute();
    }

    // Eliminar un servicio de habitación (desactivación lógica)
    public function delete($id, $modified_user) {
        $query = "UPDATE AccommodationRoomServices 
                  SET active = 0, modified_user = :modified_user, modified_date = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':modified_user', $modified_user);
        return $stmt->execute();
    }
}
