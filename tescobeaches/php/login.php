<?php
include 'includes/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $correo = trim($_POST['correo']);
    $contrasena = trim($_POST['contrasena']);

    
    if (empty($correo) && empty($contrasena)) {
        header('Location: login.html?error=Por favor, ingresa tu correo y contraseña.');
        exit();
    } elseif (empty($correo)) {
        header('Location: login.html?error=Por favor, ingresa tu correo.');
        exit();
    } elseif (empty($contrasena)) {
        header('Location: login.html?error=Por favor, ingresa tu contraseña.');
        exit();
    }

    
    $sql = "SELECT * FROM clientes WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        
        if (hash('sha256', $contrasena) === $user['contrasena']) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nombre'] = $user['nombre'];

            // Redirigir al menú principal
            header('Location: menu_principal.php');
            exit();
        } else {
            header('Location: login.html?error=Contraseña incorrecta.');
            exit();
        }
    } else {
        header('Location: login.html?error=El correo no está registrado.');
        exit();
    }
}
?>
