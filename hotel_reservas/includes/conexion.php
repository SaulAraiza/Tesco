<?php
// includes/conexion.php
include 'includes/env_read.php'; // Archivo de Lectura de Variables de Entorno

// Detalles de la conexión
$servername = getenv('DB_SERVER');  // Servidor (localhost para entorno local)
$username = getenv('DB_USER_NAME'); // Usuario de MySQL (por defecto: root en XAMPP)
$password = getenv('DB_PASSWORD');  // Contraseña de MySQL (por defecto: vacío en XAMPP, root en MAMP)
$dbname = getenv('DB_NAME');        // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>