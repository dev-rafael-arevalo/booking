<?php
require_once('../config/database.php');

class ModuleModel {
    private $conn;

    // Constructor para inicializar la conexión a la base de datos
    public function __construct() {
        $this->conn = getDatabaseConnection();

        if ($this->conn === null) {
            die("No se pudo establecer la conexión con la base de datos.");
        }
    }

    // Obtener permisos
    public function getModules($moduleId) {
        $query = "SELECT r.name 
                  FROM Modules r                  
                  WHERE r.id_module = :moduleId AND p.active = 1 AND m.active = 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':moduleId', $moduleId, PDO::PARAM_INT);
        $stmt->execute();

        $permissions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $permissions[$row['module_name']] = $row;
        }

        return $permissions;
    }

    // Obtener todos
    public function getAll() {
        $query = "SELECT * FROM Modules WHERE active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener por ID
    public function getById($id) {
        $query = "SELECT * FROM Modules WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insertar
    public function create($name, $create_user) {
        $query = "INSERT INTO Modules (name, active, create_user, create_date) 
                  VALUES (:name, 1, :create_user, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':create_user', $create_user);
        return $stmt->execute();
    }

    // Actualizar
    public function update($id, $name, $active, $modified_user) {
        $query = "UPDATE Modules 
                  SET name = :name, active = :active,
                      modified_user = :modified_user, modified_date = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':active', $active);
        $stmt->bindParam(':modified_user', $modified_user);
        return $stmt->execute();
    }

    // Eliminar
    public function delete($id, $modified_user) {
        $query = "UPDATE Modules 
                  SET active = 0, modified_user = :modified_user, modified_date = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':modified_user', $modified_user);
        return $stmt->execute();
    }
}
