<?php
session_start();
// Conexión a la base de datos
include 'includes/conexion.php'; // Archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener y limpiar los datos enviados desde el formulario
    $nombre = trim($_POST['nombre']);
    $email = trim($_POST['email']);
    $contraseña = trim($_POST['contraseña']);

    // Validar que los campos no estén vacíos
    if (empty($nombre) || empty($email) || empty($contraseña)) {
        echo "Por favor, completa todos los campos.";
        exit();
    }

    // Verificar si el correo electrónico ya está registrado
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "El correo electrónico ya está registrado. Intenta con otro.";
        exit();
    }

    $stmt->close();

    // Hashear la contraseña
    $contraseña_hashed = password_hash($contraseña, PASSWORD_DEFAULT);

    // Asignar rol por defecto como 'cliente'
    $rol = 'cliente';

    // Insertar el nuevo usuario en la base de datos
    $stmt = $conn->prepare("INSERT INTO users (nombre, email, contraseña, rol) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $email, $contraseña_hashed, $rol);

    if ($stmt->execute()) {
        // Redirigir al usuario al login con un mensaje de éxito
        header("Location: login.php?registro=exitoso");
        exit();
    } else {
        echo "Error al registrar el usuario: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Método no permitido.";
}
?>