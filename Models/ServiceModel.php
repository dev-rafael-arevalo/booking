<?php

require_once('../config/database.php');

class ServiceModel {
    private $conn;

    public function __construct() {
        $this->conn = getDatabaseConnection();

        if ($this->conn === null) {
            die("No se pudo establecer la conexión con la base de datos.");
        }
    }


    // Obtener todos los servicios
    public function getAll() {
        $query = "SELECT * FROM Services WHERE active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener un servicio por ID
    public function getById($id) {
        $query = "SELECT * FROM Services WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insertar un nuevo servicio
    public function create($name, $fa_icon, $type, $create_user) {
        $query = "INSERT INTO Services (name, fa_icon, type, active, create_user, create_date) 
                  VALUES (:name, :fa_icon, :type, 1, :create_user, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':fa_icon', $fa_icon);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':create_user', $create_user);
        return $stmt->execute();
    }

    // Actualizar un servicio
    public function update($id, $name, $fa_icon, $type, $active, $modified_user) {
        $query = "UPDATE Services 
                  SET name = :name, fa_icon = :fa_icon, type = :type, active = :active,
                      modified_user = :modified_user, modified_date = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':fa_icon', $fa_icon);
        $stmt->bindParam(':type', $type);
        $stmt->bindParam(':active', $active);
        $stmt->bindParam(':modified_user', $modified_user);
        return $stmt->execute();
    }

    // Eliminar un servicio (desactivación lógica)
    public function delete($id, $modified_user) {
        $query = "UPDATE Services 
                  SET active = 0, modified_user = :modified_user, modified_date = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':modified_user', $modified_user);
        return $stmt->execute();
    }
}
