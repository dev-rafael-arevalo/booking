<?php

require_once('../config/database.php');

class BookingsModel {
    private $conn;

    public function __construct() {
        $this->conn = getDatabaseConnection();

        if ($this->conn === null) {
            die("No se pudo establecer la conexión con la base de datos.");
        }
    }

    // Obtener todas las reservas activas
    public function getAll() {
        $query = "SELECT * FROM Bookings WHERE active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener una reserva por ID
    public function getById($id) {
        $query = "SELECT * FROM Bookings WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener reservas de una habitación específica
    public function getByAccommodationRoomId($id_accommodation_room) {
        $query = "SELECT * FROM Bookings WHERE id_accommodation_room = :id_accommodation_room AND active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_accommodation_room', $id_accommodation_room, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear una nueva reserva
    public function create($id_accommodation_room, $id_user, $id_status, $check_in, $check_out, $comments, $create_user) {
        $query = "INSERT INTO Bookings (id_accommodation_room, id_user, id_status, check_in, check_out, comments, active, create_user, create_date) 
                  VALUES (:id_accommodation_room, :id_user, :id_status, :check_in, :check_out, :comments, 1, :create_user, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_accommodation_room', $id_accommodation_room, PDO::PARAM_INT);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':id_status', $id_status, PDO::PARAM_INT);
        $stmt->bindParam(':check_in', $check_in);
        $stmt->bindParam(':check_out', $check_out);
        $stmt->bindParam(':comments', $comments);
        $stmt->bindParam(':create_user', $create_user);
        return $stmt->execute();
    }

    // Actualizar una reserva existente
    public function update($id, $id_accommodation_room, $id_user, $id_status, $check_in, $check_out, $comments, $active, $modified_user) {
        $query = "UPDATE Bookings 
                  SET id_accommodation_room = :id_accommodation_room, id_user = :id_user, id_status = :id_status, 
                      check_in = :check_in, check_out = :check_out, comments = :comments, 
                      active = :active, modified_user = :modified_user, modified_date = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':id_accommodation_room', $id_accommodation_room, PDO::PARAM_INT);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':id_status', $id_status, PDO::PARAM_INT);
        $stmt->bindParam(':check_in', $check_in);
        $stmt->bindParam(':check_out', $check_out);
        $stmt->bindParam(':comments', $comments);
        $stmt->bindParam(':active', $active, PDO::PARAM_BOOL);
        $stmt->bindParam(':modified_user', $modified_user);
        return $stmt->execute();
    }

    // Eliminar una reserva (desactivación lógica)
    public function delete($id, $modified_user) {
        $query = "UPDATE Bookings 
                  SET active = 0, modified_user = :modified_user, modified_date = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':modified_user', $modified_user);
        return $stmt->execute();
    }
}
