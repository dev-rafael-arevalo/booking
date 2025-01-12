<?php

/**
 * Función para cargar las variables de entorno desde el archivo .env
 */
function loadEnv($filePath)
{
    if (file_exists($filePath)) {
        $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Ignorar los comentarios que empiezan con #
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Separar la clave y el valor
            list($key, $value) = explode('=', $line, 2);
            // Limpiar espacios en blanco
            $key = trim($key);
            $value = trim($value);
            // Asignar la variable a $_ENV
            $_ENV[$key] = $value;
        }
    } else {
        die("El archivo .env no se encuentra en el directorio especificado.");
    }
}

/**
 * Establecer conexión a la base de datos
 */
function getDatabaseConnection()
{
    // Cargar las variables del archivo .env desde la raíz
    loadEnv(__DIR__ . '/../.env'); // Ruta relativa a la raíz del proyecto

    // Verificar que las variables necesarias estén cargadas
    $required_vars = ['DB_HOST', 'DB_DATABASE', 'DB_USERNAME', 'DB_PASSWORD'];
    foreach ($required_vars as $var) {
        if (!isset($_ENV[$var])) {
            die("La variable de entorno $var no está definida en el archivo .env.");
        }
    }

    $host = $_ENV['DB_HOST'];
    $port = $_ENV['DB_PORT'] ?? '3306'; // Default MySQL port
    $dbname = $_ENV['DB_DATABASE'];
    $username = $_ENV['DB_USERNAME'];
    $password = $_ENV['DB_PASSWORD'];

    try {
        // Crear la conexión PDO
        $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
        return new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
    } catch (PDOException $e) {
        die("Error de conexión a la base de datos: " . $e->getMessage());
    }
}

?>
