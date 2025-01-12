<?php

require_once('../config/database.php');

class AccommodationRoomsModel {
    private $conn;

    public function __construct() {
        $this->conn = getDatabaseConnection();

        if ($this->conn === null) {
            die("No se pudo establecer la conexión con la base de datos.");
        }
    }

    // Obtener todas las habitaciones activas
    public function getAll() {
        $query = "SELECT * FROM AccommodationRooms WHERE active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una habitación por ID
    public function getById($id) {
        $query = "SELECT * FROM AccommodationRooms WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener todas las habitaciones de un alojamiento específico
    public function getByAccommodationId($id_accommodation) {
        $query = "SELECT * FROM AccommodationRooms WHERE id_accommodation = :id_accommodation AND active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_accommodation', $id_accommodation, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Insertar una nueva habitación
    public function create($id_accommodation, $bed_type, $max_host, $room_number, $description, $create_user) {
        $query = "INSERT INTO AccommodationRooms (id_accommodation, bed_type, max_host, room_number, description, active, create_user, create_date) 
                  VALUES (:id_accommodation, :bed_type, :max_host, :room_number, :description, 1, :create_user, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_accommodation', $id_accommodation, PDO::PARAM_INT);
        $stmt->bindParam(':bed_type', $bed_type);
        $stmt->bindParam(':max_host', $max_host, PDO::PARAM_INT);
        $stmt->bindParam(':room_number', $room_number);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':create_user', $create_user);
        return $stmt->execute();
    }

    // Actualizar una habitación
    public function update($id, $id_accommodation, $bed_type, $max_host, $room_number, $description, $active, $modified_user) {
        $query = "UPDATE AccommodationRooms 
                  SET id_accommodation = :id_accommodation, bed_type = :bed_type, max_host = :max_host, 
                      room_number = :room_number, description = :description, active = :active, 
                      modified_user = :modified_user, modified_date = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':id_accommodation', $id_accommodation, PDO::PARAM_INT);
        $stmt->bindParam(':bed_type', $bed_type);
        $stmt->bindParam(':max_host', $max_host, PDO::PARAM_INT);
        $stmt->bindParam(':room_number', $room_number);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':active', $active, PDO::PARAM_BOOL);
        $stmt->bindParam(':modified_user', $modified_user);
        return $stmt->execute();
    }

    // Eliminar una habitación (desactivación lógica)
    public function delete($id, $modified_user) {
        $query = "UPDATE AccommodationRooms 
                  SET active = 0, modified_user = :modified_user, modified_date = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':modified_user', $modified_user);
        return $stmt->execute();
    }
}
