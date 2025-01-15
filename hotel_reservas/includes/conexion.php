<?php
// includes/conexion.php

// Detalles de la conexión
$servername = "localhost"; // Servidor (localhost para entorno local)
$username = "root";        // Usuario de MySQL (por defecto: root en XAMPP)
$password = "root";        // Contraseña de MySQL (por defecto: vacío en XAMPP, root en MAMP)
$dbname = "reservaciones_hotel"; // Nombre de la base de datos

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>