<?php
require_once('../config/database.php');
class UserModel {
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

    // Crear un nuevo usuario
    public function createUser($login, $password, $id_person, $id_role, $active, $create_user) {
        // Encriptar solo la contraseña
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);

        $query = "INSERT INTO Users (login, password, id_person, id_role, active, create_user, create_date)
                  VALUES (:login, :password, :id_person, :id_role, :active, :create_user, NOW())";

        $stmt = $this->conn->prepare($query);

        // Bind de parámetros
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':id_person', $id_person);
        $stmt->bindParam(':id_role', $id_role);
        $stmt->bindParam(':active', $active);
        $stmt->bindParam(':create_user', $create_user);

        return $stmt->execute();
    }

    // Verificar si el login ya existe
    public function isLoginExist($login) {
        $query = "SELECT COUNT(*) FROM Users WHERE login = :login";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        return $stmt->fetchColumn() > 0;
    }

    // Obtener el rol del usuario
    public function getUserRole($userId) {
        $query = "SELECT id_role FROM Users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        return $stmt->fetch();
    }   
    
    public function getUser($userId) {
        $query = "SELECT * FROM Users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $userId);
        $stmt->execute();
        return $stmt->fetch();
    }    

    // Validar si el usuario y la contraseña son correctos
    public function validateUser($login, $password) {
        $query = "SELECT id, password FROM Users WHERE login = :login AND active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Validar la contraseña
        if ($user && password_verify($password, $user['password'])) {
            return $user['id'];
        }
        return false;
    }

    public function getUsers($userId) {
        $query = "SELECT r.login 
                  FROM Users r                  
                  WHERE r.id_user = :userId AND p.active = 1 AND m.active = 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':userId', $userId, PDO::PARAM_INT);
        $stmt->execute();

        $permissions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $permissions[$row['login']] = $row;
        }

        return $permissions;
    }

    // Obtener todos
    public function getAll() {
        $query = "SELECT * FROM Users WHERE active = 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Obtener por ID
    public function getById($id) {
        $query = "SELECT * FROM Users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Insertar
    public function create($login, $password, $id_person, $id_role, $create_user) {
        $query = "INSERT INTO Users (login, password, id_person, id_role, active, create_user, create_date) 
                  VALUES (:login, :password, :id_person, :id_role, 1, :create_user, NOW())";
        
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $hashed_password);
        $stmt->bindParam(':id_person', $id_person);
        $stmt->bindParam(':id_role', $id_role);
        $stmt->bindParam(':create_user', $create_user);
        return $stmt->execute();
    }

    // Actualizar
    public function update($id,$login, $password, $id_person, $id_role, $create_user) {
        $query = "UPDATE Users 
                  SET login = :login, password = :password, id_person=:id_person, id_role=:id_role, active = :active,
                      modified_user = :create_user, modified_date = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':id_person', $id_person);
        $stmt->bindParam(':id_role', $id_role);
        $stmt->bindParam(':active', $active);
        $stmt->bindParam(':create_user', $create_user);
        return $stmt->execute();
    }

    // Eliminar
    public function delete($id, $modified_user) {
        $query = "UPDATE Users 
                  SET active = 0, modified_user = :modified_user, modified_date = NOW() 
                  WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':modified_user', $modified_user);
        return $stmt->execute();
    }    
}
