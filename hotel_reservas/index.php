<?php
// index.php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Puedes acceder a la información del usuario utilizando las variables de sesión
$nombre_usuario = $_SESSION['usuario_nombre'];
$rol_usuario = $_SESSION['usuario_rol'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Página Principal - Reservación Hotelera</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>
    <h2>Bienvenido, <?php echo htmlspecialchars($nombre_usuario); ?>!</h2>
    <p><a href="logout.php">Cerrar Sesión</a></p>
    
    <!-- Contenido de la página principal -->
    <p>Aquí puedes reservar habitaciones y gestionar tus reservas.</p>
</body>
</html>