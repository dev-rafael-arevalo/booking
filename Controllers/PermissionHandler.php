<?php
require_once('../Helpers/jwt_helper.php');
require_once('UserController.php');
require_once('PermissionController.php');
require_once('../Models/ModuleModel.php');

class PermissionHandler {
    private $decodedToken;

    public function __construct() {
        $this->decodedToken = $this->validateToken();
        $this->user = new UserController();                
    }

    private function validateToken() {
        if (!isset($_COOKIE['auth_token'])) {
            return null;
        }

        try {
            $jwt = $_COOKIE['auth_token'];
            return decodeJWT($jwt); // Asume que decodeJWT retorna los datos decodificados del token.
        } catch (Exception $e) {
            return null;
        }
    }

    public function hasPermission($requiredPermission) {
        if (!$this->decodedToken || !isset($this->decodedToken['permissions'])) {
            return false;
        }

        return in_array($requiredPermission, $this->decodedToken['permissions']);
    }

    public function isLoggedIn() {
        return $this->decodedToken !== null;
    }

    public function getUserRole() {
        return $this->decodedToken['roleId'];    
    }

     
    
}
?>
