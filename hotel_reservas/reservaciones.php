<?php
// reservaciones.php
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

// Consultar las reservaciones del usuario
$sql = "SELECT fecha_entrada, fecha_salida, huespedes, tipo_habitacion, fecha_reservacion 
        FROM reservaciones WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $_SESSION['usuario_id']);
$stmt->execute();
$result = $stmt->get_result();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Reservaciones</title>
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
                    <li class="nav-item"><a class="nav-link" href="reservaciones.php">Mis Reservaciones</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar Sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Reservaciones -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Mis Reservaciones</h2>
        <table class="table table-bordered">
            <thead class="table-light">
                <tr>
                    <th>Fecha de Entrada</th>
                    <th>Fecha de Salida</th>
                    <th>Huéspedes</th>
                    <th>Tipo de Habitación</th>
                    <th>Fecha de Reservación</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['fecha_entrada']); ?></td>
                        <td><?php echo htmlspecialchars($row['fecha_salida']); ?></td>
                        <td><?php echo htmlspecialchars($row['huespedes']); ?></td>
                        <td><?php echo htmlspecialchars($row['tipo_habitacion']); ?></td>
                        <td><?php echo htmlspecialchars($row['fecha_reservacion']); ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
