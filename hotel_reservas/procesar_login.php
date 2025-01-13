<?php
// procesar_login.php
session_start();
include 'includes/conexion.php'; // Asegúrate de tener este archivo para la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener y limpiar los datos ingresados por el usuario
    $email = trim($_POST['email']);
    $contraseña = trim($_POST['contraseña']);

    // Validar que los campos no estén vacíos
    if (empty($email) || empty($contraseña)) {
        $_SESSION['error'] = "Por favor, completa todos los campos.";
        header("Location: login.php");
        exit();
    }

    // Preparar la consulta para evitar inyecciones SQL
    $stmt = $conn->prepare("SELECT id, nombre, email, contraseña, rol FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        // Verificar si el correo electrónico existe en la base de datos
        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $nombre, $email_db, $contraseña_db, $rol);
            $stmt->fetch();

            // Verificar la contraseña
            if (password_verify($contraseña, $contraseña_db)) {
                // Iniciar la sesión y almacenar información del usuario
                $_SESSION['usuario_id'] = $id;
                $_SESSION['usuario_nombre'] = $nombre;
                $_SESSION['usuario_email'] = $email_db;
                $_SESSION['usuario_rol'] = $rol;

                // Redirigir según el rol del usuario
                if ($rol == 'admin') {
                    header("Location: admin.php");
                } else {
                    header("Location: index.php");
                }
                exit();
            } else {
                $_SESSION['error'] = "Contraseña incorrecta.";
                header("Location: login.php");
                exit();
            }
        } else {
            $_SESSION['error'] = "No se encontró una cuenta con ese correo electrónico.";
            header("Location: login.php");
            exit();
        }

        $stmt->close();
    } else {
        // Error en la preparación de la consulta
        $_SESSION['error'] = "Error en la conexión. Por favor, inténtalo de nuevo más tarde.";
        header("Location: login.php");
        exit();
    }
}

header("Location: login.php");
exit();
?>