<?php

require_once __DIR__ . '/../Models/UserModel.php';

class UserController {

    private $userModel;

    public function __construct() {
        // Instanciar el modelo de Usuario
        $this->userModel = new UserModel();
    }

    // Función para registrar un nuevo usuario
    public function createUser($login, $password, $id_person, $id_role, $active, $create_user) {
        // Verificar si el login ya existe
        if ($this->userModel->isLoginExist($login)) {
            return ['error' => 'El login ya está en uso.'];
        }

        // Crear el usuario
        if ($this->userModel->createUser($login, $password, $id_person, $id_role, $active, $create_user)) {
            return ['success' => 'Usuario registrado exitosamente.'];
        }

        return ['error' => 'Hubo un problema al registrar el usuario.'];
    }

    // Función para validar un login
    public function validateLogin($login, $password) {
        $userId = $this->userModel->validateUser($login, $password);
        if ($userId) {
            return ['success' => 'Login válido.', 'user_id' => $userId];
            $_SESSION['iduser']=$userId;
        }

        return ['error' => 'Credenciales incorrectas.'];
    }

    // Otros métodos relacionados con el usuario (como obtener usuario por ID, etc.)
    public function getUser($id) {
        return $this->userModel->getUserById($id);
    }

    // Obtener rol
    public function getUserRole($id) {
        return $this->userModel->getUserRole($id);
    }
        // Guardar un nuevo estados
        public function store($login, $password, $id_person, $id_role, $create_user) {
            $result = $this->UserModel->create($login, $password, $id_person, $id_role ,$create_user);
            if ($result) {
                $mensaje = "Usuario creado con éxito.";
                // Redirigir después de actualizar (para evitar el reenvío del formulario)
                header("Location: user_list.php?mensaje='" . $mensaje . "'");
                exit();
            } else {
                $mensaje = "Error al actualizar el estado.";
                // Redirigir después de actualizar (para evitar el reenvío del formulario)
                header("Location: user_list.php?mensaje='" . $mensaje . "'");
                exit();
            }
        }
    
        // Obtener un estados por ID
        public function getId($id) {
            return $this->UserModel->getById($id);
        }
    
        // Actualizar un estado
        public function update($id, $login, $password, $id_person, $id_role, $active, $modified_user) {
            $result = $this->UserModel->update($id, $login, $password, $id_person, $id_role, $active, $modified_user);
            if ($result) {
                $mensaje = "Estado actualizado con éxito.";
                // Redirigir después de actualizar (para evitar el reenvío del formulario)
                header("Location: user_list.php?mensaje='" . $mensaje . "'");
            } else {
                $mensaje = "Error al guardar el estado.";
                // Redirigir después de actualizar (para evitar el reenvío del formulario)
                header("Location: user_list.php?mensaje='" . $mensaje . "'");
            }
        }
    
        // Eliminar un estado (desactivación lógica)
        public function delete($id, $modified_user) {
            $result = $this->UserModel->delete($id, $modified_user);
            if ($result) {
                $mensaje = "Estado de la reserva eliminada.";
                // Redirigir después de actualizar (para evitar el reenvío del formulario)
                header("Location: user_list.php?mensaje='" . $mensaje . "'");
            } else {
                $mensaje = "Error al eliminar el estado.";
                // Redirigir después de actualizar (para evitar el reenvío del formulario)
                header("Location: user_list.php?mensaje='" . $mensaje . "'");
            }
        }
}
