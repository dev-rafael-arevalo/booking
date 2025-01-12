<?php
require_once('../config/database.php');

class PersonModel {
    private $conn;

    // Constructor para inicializar la conexión a la base de datos
    public function __construct() {
        // Obtener la conexión desde la función getDatabaseConnection() en el archivo de configuración
        $this->conn = getDatabaseConnection();
        
        // Verificar que la conexión fue exitosa
        if ($this->conn === null) {
            die("No se pudo establecer la conexión con la base de datos.");
        }
    }

    // Crear una nueva persona
    public function createPerson($full_name, $address, $email, $phone, $iso_country, $active, $create_person) {
        $query = "INSERT INTO Persons (full_name, address, email, phone, iso_country, active, create_person, create_date)
                  VALUES (:full_name, :address, :email, :phone, :iso_country, :active, :create_person, curdate())";

        $stmt = $this->conn->prepare($query);

        // Bind de parámetros
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':iso_country', $iso_country);
        $stmt->bindParam(':active', $active);
        $stmt->bindParam(':create_person', $create_person);

        return $stmt->execute();
    }

    // Obtener persona por ID
    public function getPersonById($id) {
        $query = "SELECT * FROM Persons WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Obtener persona por Email
    public function getPersonByEmail($email) {
        $query = "SELECT * FROM Persons WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }    

    // Verificar si el correo electrónico ya existe
    public function isEmailExist($email) {              
        $query = "SELECT COUNT(*) FROM Persons WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    public function getPersons($personId) {
        $query = "SELECT r.full_name 
                  FROM Persons r                  
                  WHERE r.id_person = :personId AND p.active = 1 AND m.active = 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':personId', $personId, PDO::PARAM_INT);
        $stmt->execute();

        $permissions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $permissions[$row['full_name']] = $row;
        }

        return $permissions;
    }

    // Obtener todos
    public function getAll() {
        $query = "SELECT * FROM Persons WHERE active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener por ID
    public function getById($id) {
        $query = "SELECT * FROM Persons WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insertar
    public function create($full_name, $address, $email, $phone, $iso_country, $create_person) {
        $query = "INSERT INTO Persons (full_name, address, email, phone, iso_country, active, create_person, create_date) 
                  VALUES (:full_name, :address, :email, :phone, :iso_country, 1, :create_person, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':iso_country', $iso_country);
        $stmt->bindParam(':create_person', $create_person);
        return $stmt->execute();
    }

    // Actualizar
    public function update($id,$full_name, $address, $email, $phone, $iso_country, $create_person) {
        $query = "UPDATE Persons 
                  SET full_name = :full_name, address = :address, email=:email, phone=:phone, iso_country=:iso_country, active = :active,
                      modified_person = :create_person, modified_date = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':iso_country', $iso_country);
        $stmt->bindParam(':active', $active);
        $stmt->bindParam(':create_person', $create_person);
        return $stmt->execute();
    }

    // Eliminar
    public function delete($id, $modified_person) {
        $query = "UPDATE Persons 
                  SET active = 0, modified_person = :modified_person, modified_date = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':modified_person', $modified_person);
        return $stmt->execute();
    }    
}
?>
