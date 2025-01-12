<?php
require_once('../config/database.php');

class PermissionModel {
    private $conn;

    // Constructor para inicializar la conexión a la base de datos
    public function __construct() {
        $this->conn = getDatabaseConnection();

        if ($this->conn === null) {
            die("No se pudo establecer la conexión con la base de datos.");
        }
    }

    // Obtener permisos por rol
    public function getPermissionsByRole($roleId) {
        $query = "SELECT p.id_module, m.name AS module_name, p.per_read, p.per_create, p.per_update, 
                         p.per_delete, p.per_filter, p.per_report 
                  FROM Permissions p
                  INNER JOIN Modules m ON p.id_module = m.id
                  WHERE p.id_role = :roleId AND p.active = 1 AND m.active = 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':roleId', $roleId, PDO::PARAM_INT);
        $stmt->execute();

        $permissions = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $permissions[$row['module_name']] = $row;
        }

        return $permissions;
    }

    // Obtener permisos por rol
    public function getPermissionsByModuleRole($moduleName,$roleId) {
        $query = "SELECT p.id_role,p.id_module,m.name, p.per_read, p.per_create, p.per_update, 
                         p.per_delete, p.per_filter, p.per_report 
                  FROM Permissions p
                  INNER JOIN Modules m ON p.id_module = m.id                  
                  WHERE p.id_role = :roleId AND m.name = :moduleName AND p.active = 1 AND m.active = 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':roleId', $roleId, PDO::PARAM_INT);
        $stmt->bindParam(':moduleName', $moduleName);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

        // Obtener todos
        public function getAll() {
            $query = "SELECT * FROM Permissions WHERE active = 1";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    
        // Obtener por ID
        public function getById($idRol) {
            $query = "SELECT p.id, p.id_module, p.id_role, per_read, per_create, per_update, per_delete, per_filter, per_report, p.create_user, p.create_date,r.name as name_role FROM Permissions p 
            INNER JOIN Roles as r ON p.id_role=r.id
            WHERE p.id_role = :idRol";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':idRol', $idRol, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    
        // Insertar
        public function create($module, $role, $per_read, $per_create, $per_update, $per_delete, $per_filter, $per_report, $create_user) {
            $query = "INSERT INTO Permissions (id_module, id_role, per_read, per_create, per_update, per_delete, per_filter, per_report, create_user, create_date) 
                      VALUES (:id_module, :id_rol, :per_read, :per_create, :per_update, :per_delete, :per_filter, :per_report, 1, :create_user, NOW())";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_module', $module);
            $stmt->bindParam(':id_rol', $role);
            $stmt->bindParam(':per_read', $per_read);
            $stmt->bindParam(':per_create', $per_create);
            $stmt->bindParam(':per_update', $per_update);
            $stmt->bindParam(':per_delete', $per_delete);
            $stmt->bindParam(':per_filter', $per_filter);
            $stmt->bindParam(':per_report', $per_report);
            $stmt->bindParam(':create_user', $create_user);
            return $stmt->execute();
        }
    
        // Actualizar
        public function update($id, $module, $role, $per_read, $per_create, $per_update, $per_delete, $per_filter, $per_report, $create_user) {
            $query = "UPDATE Permissions 
                      SET id_module = :id_module, id_role = :id_rol, per_read = :per_read, per_create=:per_create, per_update=:per_update, per_delete=:per_delete, per_filter=:per_filter, per_report=:per_report, active = 1,
                          modified_user = :create_user, modified_date = NOW() 
                      WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':id_module', $module);
            $stmt->bindParam(':id_rol', $role);
            $stmt->bindParam(':per_read', $per_read);
            $stmt->bindParam(':per_create', $per_create);
            $stmt->bindParam(':per_update', $per_update);
            $stmt->bindParam(':per_delete', $per_delete);
            $stmt->bindParam(':per_filter', $per_filter);
            $stmt->bindParam(':per_report', $per_report);
            $stmt->bindParam(':create_user', $create_user);            
            return $stmt->execute();
        }
    
        // Eliminar
        public function delete($id, $modified_user) {
            $query = "UPDATE Permissions 
                      SET active = 0, modified_user = :modified_user, modified_date = NOW() 
                      WHERE id = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->bindParam(':modified_user', $modified_user);
            return $stmt->execute();
        }
}
