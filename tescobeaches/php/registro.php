<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    // Validar contraseñas
    if ($contrasena !== $confirmar_contrasena) {
        echo '<script>alert("Las contraseñas no coinciden. Intenta nuevamente."); window.location.href="registro.html";</script>';
        exit();
    }

    // Encriptar la contraseña
    $contrasena_hash = hash('sha256', $contrasena);

    // Insertar datos en la base de datos
    $sql = "INSERT INTO clientes (nombre, correo, contrasena) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $nombre, $correo, $contrasena_hash);

    if ($stmt->execute()) {
        echo '<script>alert("Registro exitoso. Ahora puedes iniciar sesión."); window.location.href="login.html";</script>';
    } else {
        echo '<script>alert("Error al registrar. Verifica tus datos o intenta más tarde."); window.location.href="registro.html";</script>';
    }

    $stmt->close();
    $conn->close();
}
?>

