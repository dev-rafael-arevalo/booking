<?php

require_once __DIR__ . '/../Models/PersonModel.php';

class PersonController {

    private $personModel;

    public function __construct() {
        // Instanciar el modelo de Persona
        $this->personModel = new PersonModel();
    }

    // Función para crear una persona (registrar un usuario en la plataforma)
    public function createPerson($full_name, $address, $email, $phone, $iso_country, $active, $create_user) {
        
        // Verificar si el correo electrónico ya existe
        if ($this->personModel->isEmailExist($email)) {
            return ['error' => 'El correo electrónico ya está registrado.'];
        }      

        // Crear la persona en la base de datos
        if ($this->personModel->createPerson($full_name, $address, $email, $phone, $iso_country, $active, $create_user)) {
            return ['success' => 'Persona registrada exitosamente.'];
        }

        return ['error' => 'Hubo un problema al registrar la persona.'];
    }

    // Otros métodos relacionados con la persona (como obtener persona por ID, etc.)
    public function getPerson($id) {
        return $this->personModel->getPersonById($id);
    }

    public function getPersonByEmail($email) {
        return $this->personModel->getPersonByEmail($email);
    }

}
