<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'reservaciones_hotel');
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Obtener información del usuario
$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT nombre, email, imagen_perfil FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $usuario_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Manejar subida de imagen
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['imagen_perfil'])) {
    $imagen = $_FILES['imagen_perfil'];

    if ($imagen['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($imagen['name'], PATHINFO_EXTENSION);
        $nuevo_nombre = "perfil_$usuario_id." . $ext;
        $ruta_destino = "uploads/$nuevo_nombre";

        if (move_uploaded_file($imagen['tmp_name'], $ruta_destino)) {
            $sql_update = "UPDATE users SET imagen_perfil = ? WHERE id = ?";
            $stmt_update = $conn->prepare($sql_update);
            $stmt_update->bind_param('si', $nuevo_nombre, $usuario_id);
            $stmt_update->execute();

            header("Location: perfil.php"); // Recargar la página
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="index.php">TescoBeaches</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.php">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="habitaciones.php">Habitaciones</a></li>
                    <li class="nav-item"><a class="nav-link" href="contacto.php">Contacto</a></li>
                    <li class="nav-item"><a class="nav-link" href="perfil.php">Perfil</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Perfil -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Perfil de Usuario</h2>
            <div class="row justify-content-center">
                <div class="col-md-6 text-center">
                    <div class="mb-3">
                        <img src="<?php echo $user['imagen_perfil'] ? 'uploads/' . htmlspecialchars($user['imagen_perfil']) : 'https://via.placeholder.com/150'; ?>" alt="Imagen de perfil" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <h4><?php echo htmlspecialchars($user['nombre']); ?></h4>
                    <p><?php echo htmlspecialchars($user['email']); ?></p>
                    <form action="perfil.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="imagen_perfil" class="form-label">Cambiar imagen de perfil</label>
                            <input type="file" class="form-control" id="imagen_perfil" name="imagen_perfil" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Subir imagen</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p class="mb-0">&copy; 2025 TescoBeaches. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
