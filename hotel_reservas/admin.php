<?php
// admin.php
session_start();

// Verificar si el usuario ha iniciado sesión y si es administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] != 'admin') {
    header("Location: login.php");
    exit();
}

// Aquí puedes agregar la lógica para el panel de administración
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Reservación Hotelera</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <h2>Panel de Administración</h2>
    <p><a href="logout.php">Cerrar Sesión</a></p>
    
    <!-- Contenido del panel de administración -->
    <p>Aquí puedes gestionar habitaciones, reservas y usuarios.</p>
</body>
</html>