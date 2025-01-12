# Sistema de Reservas en PHP

## Descripción

Este proyecto es un sistema de reservas desarrollado en PHP puro que utiliza una base de datos MySQL para gestionar alojamientos, servicios, habitaciones y reservas. Permite a los usuarios realizar reservas en alojamientos disponibles, gestionar servicios asociados y administrar habitaciones.

## Requisitos

- **Servidor Web**: Apache o Nginx
- **PHP**: Versión 7.4 o superior
- **Base de Datos**: MySQL 5.7 o superior
- **Extensiones de PHP**:
  - `mysqli`
  - `pdo_mysql`
  - `mbstring`
  - `gd` (para manejo de imágenes)

## Instalación

1. **Clonar el repositorio**:

   ```bash
   git clone https://github.com/dev-rafael-arevalo/booking.git

    Configurar el servidor web:
        Coloca el contenido del repositorio en el directorio raíz de tu servidor web.
        Asegúrate de que el servidor tenga permisos adecuados para acceder y modificar los archivos.

    Configurar la base de datos:
        Crea una base de datos en MySQL llamada booking_system.
        Importa el archivo database.sql ubicado en el directorio sql/ para crear las tablas necesarias.

    Configurar las credenciales de la base de datos:

        Renombra el archivo config.example.php a config.php.

        Edita database.php con las credenciales de tu base de datos:

        <?php
        return [
            'db_host' => 'localhost',
            'db_name' => 'booking_system',
            'db_user' => 'root',
            'db_pass' => '',
        ];

    Configurar el entorno:
        Asegúrate de que el servidor tenga permisos adecuados para acceder y modificar los archivos en el directorio uploads/ para el manejo de imágenes.

Uso

    Acceder al sistema:
        Abre tu navegador y navega a la URL donde se encuentra el proyecto (por ejemplo, http://localhost/booking).

    Registrar un nuevo usuario:
        En la página de inicio, haz clic en "Registrarse" y completa el formulario con tus datos.

    Iniciar sesión:
        Después de registrarte, inicia sesión con tus credenciales.

    Gestionar alojamientos:
        Como administrador, puedes agregar, editar o eliminar alojamientos desde el panel de administración.

    Gestionar servicios y habitaciones:
        Asocia servicios a los alojamientos y administra las habitaciones disponibles.

    Realizar reservas:
        Los usuarios pueden buscar alojamientos disponibles y realizar reservas según sus preferencias.

Estructura del Proyecto

    index.php: Página de inicio del sistema.
    login.php: Página de inicio de sesión.
    register.php: Página de registro de nuevos usuarios.
