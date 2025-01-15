<?php
// edit_reservacion.php
session_start();

// Verificar si el usuario tiene el rol de administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Conexión a la base de datos
$conn = new mysqli('localhost', 'root', '', 'reservaciones_hotel');
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se ha enviado un ID de reservación
if (!isset($_GET['id'])) {
    header("Location: admin_dashboard.php");
    exit();
}

$reservacion_id = $_GET['id'];

// Obtener los datos de la reservación
$sql = "SELECT * FROM reservaciones WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $reservacion_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    header("Location: admin_dashboard.php");
    exit();
}

$reservacion = $result->fetch_assoc();

// Manejar la actualización de la reservación
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fecha_entrada = $_POST['fecha_entrada'];
    $fecha_salida = $_POST['fecha_salida'];
    $huespedes = $_POST['huespedes'];
    $tipo_habitacion = $_POST['tipo_habitacion'];

    $sql_update = "UPDATE reservaciones SET fecha_entrada = ?, fecha_salida = ?, huespedes = ?, tipo_habitacion = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param('ssisi', $fecha_entrada, $fecha_salida, $huespedes, $tipo_habitacion, $reservacion_id);

    if ($stmt_update->execute()) {
        header("Location: admin_dashboard.php");
        exit();
    } else {
        $error_message = "Error al actualizar la reservación.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Reservación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Editar Reservación</h2>

        <?php if (!empty($error_message)) { ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php } ?>

        <form method="POST">
            <div class="mb-3">
                <label for="fecha_entrada" class="form-label">Fecha de Entrada</label>
                <input type="date" class="form-control" id="fecha_entrada" name="fecha_entrada" value="<?php echo htmlspecialchars($reservacion['fecha_entrada']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="fecha_salida" class="form-label">Fecha de Salida</label>
                <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" value="<?php echo htmlspecialchars($reservacion['fecha_salida']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="huespedes" class="form-label">Número de Huéspedes</label>
                <input type="number" class="form-control" id="huespedes" name="huespedes" value="<?php echo htmlspecialchars($reservacion['huespedes']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="tipo_habitacion" class="form-label">Tipo de Habitación</label>
                <select class="form-control" id="tipo_habitacion" name="tipo_habitacion" required>
                    <option value="Habitación Deluxe" <?php echo $reservacion['tipo_habitacion'] === 'Habitación Deluxe' ? 'selected' : ''; ?>>Habitación Deluxe</option>
                    <option value="Suite Ejecutiva" <?php echo $reservacion['tipo_habitacion'] === 'Suite Ejecutiva' ? 'selected' : ''; ?>>Suite Ejecutiva</option>
                    <option value="Habitación Familiar" <?php echo $reservacion['tipo_habitacion'] === 'Habitación Familiar' ? 'selected' : ''; ?>>Habitación Familiar</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            <a href="admin_dashboard.php" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
