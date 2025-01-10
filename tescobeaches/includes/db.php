<?php
// Configuración de la conexión a la base de datos
$host = 'localhost';
$user = 'root';
$password = ''; // Si tienes contraseña en MySQL, añádela aquí
$database = 'TESCoBeaches';

// Crear conexión
$conn = new mysqli($host, $user, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die('Error de conexión: ' . $conn->connect_error);
}
?>
