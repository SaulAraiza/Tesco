<?php
session_start();
// Conexión a la base de datos
include 'includes/conexion.php'; // Archivo de conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener y limpiar los datos del formulario
    $email = trim($_POST['email']);
    $new_password = trim($_POST['new_password']);

    // Validar que los campos no estén vacíos
    if (empty($email) || empty($new_password)) {
        die("Por favor, completa todos los campos.");
    }

    // Verificar si el correo existe en la base de datos
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        die("El correo electrónico no está registrado.");
    }

    $stmt->close();

    // Hashear la nueva contraseña
    $new_password_hashed = password_hash($new_password, PASSWORD_DEFAULT);

    // Actualizar la contraseña en la base de datos
    $stmt = $conn->prepare("UPDATE users SET contraseña = ? WHERE email = ?");
    $stmt->bind_param("ss", $new_password_hashed, $email);

    if ($stmt->execute()) {
        // Redirigir al login con un mensaje de éxito
        header("Location: login.php?password_reset=exitoso");
        exit();
    } else {
        echo "Error al actualizar la contraseña: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
} else {
    die("Método no permitido.");
}
?>