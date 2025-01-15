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

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', 'root', 'reservaciones_hotel');
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Manejar la reservación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $checkIn = $_POST['checkIn'];
    $checkOut = $_POST['checkOut'];
    $guests = $_POST['guests'];
    $roomType = $_POST['roomType'];

    // Verificar disponibilidad
    $sqlCheck = "SELECT COUNT(*) AS total FROM reservaciones 
                 WHERE tipo_habitacion = ? 
                 AND ((fecha_entrada <= ? AND fecha_salida >= ?) 
                 OR (fecha_entrada <= ? AND fecha_salida >= ?))";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param('sssss', $roomType, $checkOut, $checkIn, $checkIn, $checkOut);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result();
    $rowCheck = $resultCheck->fetch_assoc();

    if ($rowCheck['total'] > 0) {
        $errorMessage = "La habitación seleccionada no está disponible en las fechas indicadas.";
    } else {
        // Insertar la reservación si está disponible
        $sql = "INSERT INTO reservaciones (usuario_id, fecha_entrada, fecha_salida, huespedes, tipo_habitacion) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('issis', $_SESSION['usuario_id'], $checkIn, $checkOut, $guests, $roomType);
        if ($stmt->execute()) {
            $successMessage = "Reservación realizada con éxito.";
        } else {
            $errorMessage = "Error al realizar la reservación.";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="#">TescoBeaches</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
                    <li class="nav-item"><a class="nav-link" href="./reservaciones.php">Reservaciones</a></li>
                    <li class="nav-item"><a class="nav-link" href="./habitaciones.php">Habitaciones</a></li>
                    <li class="nav-item"><a class="nav-link" href="./contacto.php">Contacto</a></li>
                    <li class="nav-item"><a class="nav-link" href="./perfil.php">Perfil</a></li>
					<li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="bg-dark text-white text-center py-5" style="background: url('https://via.placeholder.com/1500x600') no-repeat center center/cover;">
        <div class="container">
            <h1 class="display-4">Bienvenido a TescoBeaches</h1>
            <p class="lead">Hola, <?php echo htmlspecialchars($nombre_usuario); ?>. El lugar perfecto para tus vacaciones soñadas</p>
            <a href="#reservaciones" class="btn btn-primary btn-lg">Reservar ahora</a>
        </div>
    </header>

    <!-- Buscador de disponibilidad -->
    <section id="reservaciones" class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Busca tu habitación ideal</h2>
            <?php if (!empty($successMessage)) echo "<div class='alert alert-success'>$successMessage</div>"; ?>
            <?php if (!empty($errorMessage)) echo "<div class='alert alert-danger'>$errorMessage</div>"; ?>
            <form class="row g-3" method="POST">
                <div class="col-md-4">
                    <label for="checkIn" class="form-label">Fecha de entrada</label>
                    <input type="date" class="form-control" id="checkIn" name="checkIn" required>
                </div>
                <div class="col-md-4">
                    <label for="checkOut" class="form-label">Fecha de salida</label>
                    <input type="date" class="form-control" id="checkOut" name="checkOut" required>
                </div>
                <div class="col-md-4">
                    <label for="guests" class="form-label">Número de huéspedes</label>
                    <input type="number" class="form-control" id="guests" name="guests" min="1" max="10" required>
                </div>
                <div class="col-md-4">
                    <label for="roomType" class="form-label">Tipo de habitación</label>
                    <select class="form-control" id="roomType" name="roomType" required>
                        <option value="Habitación Deluxe">Habitación Deluxe - $150/noche</option>
                        <option value="Suite Ejecutiva">Suite Ejecutiva - $200/noche</option>
                        <option value="Habitación Familiar">Habitación Familiar - $180/noche</option>
                    </select>
                </div>
                <div class="col-12 text-center mt-3">
                    <button type="submit" class="btn btn-success">Reservar</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Habitaciones -->
    <section id="habitaciones" class="py-5 bg-light">
        <div class="container">
            <h2 class="text-center mb-4">Nuestras habitaciones</h2>
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Habitación 1">
                        <div class="card-body">
                            <h5 class="card-title">Habitación Deluxe</h5>
                            <p class="card-text">Con todas las comodidades que necesitas para relajarte. $150/noche</p>
                            <a href="#reservaciones" class="btn btn-primary">Reservar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Habitación 2">
                        <div class="card-body">
                            <h5 class="card-title">Suite Ejecutiva</h5>
                            <p class="card-text">El espacio ideal para trabajar y descansar. $200/noche</p>
                            <a href="#reservaciones" class="btn btn-primary">Reservar</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Habitación 3">
                        <div class="card-body">
                            <h5 class="card-title">Habitación Familiar</h5>
                            <p class="card-text">Perfecta para compartir momentos inolvidables. $180/noche</p>
                            <a href="#reservaciones" class="btn btn-primary">Reservar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3">
        <p class="mb-0">&copy; 2025 Hotel [Nombre]. Todos los derechos reservados.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
