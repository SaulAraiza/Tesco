<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = $_POST['correo'];

    $sql = "SELECT id FROM clientes WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo 'Hemos encontrado tu correo. Te enviaremos un código.';
        // Lógica para enviar el correo con el código
    } else {
        echo 'Lo sentimos, este correo no está registrado.';
    }

    $stmt->close();
}
?>
