<?php

require_once __DIR__ . '/../Models/UserModel.php';

class UserService {

    private $userModel;

    public function __construct() {
        $this->userModel = new UserModel();
    }

    // Crear un usuario
    public function createUser($login, $password, $id_person, $id_role, $active, $create_user) {
        if ($this->userModel->isLoginExist($login)) {
            return ['error' => 'El login ya está en uso.'];
        }

        // Crear el usuario
        if ($this->userModel->createUser($login, $password, $id_person, $id_role, $active, $create_user)) {
            return ['success' => 'Usuario registrado exitosamente.'];
        }

        return ['error' => 'Hubo un problema al registrar el usuario.'];
    }

    // Otros métodos relacionados con la gestión del usuario.
}
