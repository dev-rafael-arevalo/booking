<?php

require_once __DIR__ . '/../Models/PersonModel.php';

class PersonService {

    private $personModel;

    public function __construct() {
        $this->personModel = new PersonModel();
    }

    // Crear una persona
    public function createPerson($full_name, $address, $email, $phone, $iso_country, $active, $create_user) {
        if ($this->personModel->isEmailExist($email)) {
            return ['error' => 'El correo electrónico ya está registrado.'];
        }

        if ($this->personModel->createPerson($full_name, $address, $email, $phone, $iso_country, $active, $create_user)) {
            return ['success' => 'Persona registrada exitosamente.'];
        }

        return ['error' => 'Hubo un problema al registrar la persona.'];
    }

    // Otros métodos relacionados con la gestión de personas.
}
