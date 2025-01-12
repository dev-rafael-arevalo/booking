<?php

require_once('../config/database.php');

class AccommodationsModel {
    private $conn;

    public function __construct() {
        $this->conn = getDatabaseConnection();

        if ($this->conn === null) {
            die("No se pudo establecer la conexión con la base de datos.");
        }
    }

    // Obtener todos los alojamientos activos
    public function getAll() {
        $query = "SELECT * FROM Accommodations WHERE active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un alojamiento por ID
    public function getById($id) {
        $query = "SELECT * FROM Accommodations WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insertar un nuevo alojamiento
    public function create($id_user, $name, $address, $email_contact, $phone, $iso_country, $description, $create_user) {
        $query = "INSERT INTO Accommodations (id_user, name, address, email_contact, phone, iso_country, description, active, create_user, create_date) 
                  VALUES (:id_user, :name, :address, :email_contact, :phone, :iso_country, :description, 1, :create_user, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':email_contact', $email_contact);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':iso_country', $iso_country);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':create_user', $create_user);
        return $stmt->execute();
    }

    // Actualizar un alojamiento
    public function update($id, $id_user, $name, $address, $email_contact, $phone, $iso_country, $description, $active, $modified_user) {
        $query = "UPDATE Accommodations 
                  SET id_user = :id_user, name = :name, address = :address, email_contact = :email_contact, 
                      phone = :phone, iso_country = :iso_country, description = :description, active = :active, 
                      modified_user = :modified_user, modified_date = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':email_contact', $email_contact);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':iso_country', $iso_country);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':active', $active, PDO::PARAM_BOOL);
        $stmt->bindParam(':modified_user', $modified_user);
        return $stmt->execute();
    }

    // Eliminar un alojamiento (desactivación lógica)
    public function delete($id, $modified_user) {
        $query = "UPDATE Accommodations 
                  SET active = 0, modified_user = :modified_user, modified_date = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':modified_user', $modified_user);
        return $stmt->execute();
    }
}
