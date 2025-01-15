<?php
// admin_dashboard.php
session_start();
// Conexión a la base de datos
include 'includes/conexion.php'; // Archivo de conexión a la base de datos

// Verificar si el usuario tiene el rol de administrador
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_rol'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Manejar eliminación de reservación
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql_delete = "DELETE FROM reservaciones WHERE id = ?";
    $stmt_delete = $conn->prepare($sql_delete);
    $stmt_delete->bind_param('i', $delete_id);
    $stmt_delete->execute();
    header("Location: admin_dashboard.php");
    exit();
}

// Consultar todas las reservaciones
$sql_reservaciones = "SELECT r.id, r.fecha_entrada, r.fecha_salida, r.huespedes, r.tipo_habitacion, u.nombre, u.email, 
                        CASE r.tipo_habitacion 
                            WHEN 'Habitación Deluxe' THEN 150 
                            WHEN 'Suite Ejecutiva' THEN 200 
                            WHEN 'Habitación Familiar' THEN 180 
                        END AS precio
                      FROM reservaciones r
                      JOIN users u ON r.usuario_id = u.id";
$result_reservaciones = $conn->query($sql_reservaciones);

if (!$result_reservaciones) {
    die("Error en la consulta: " . $conn->error);
}

// Calcular ganancias del día
$fecha_actual = date('Y-m-d');
$sql_ganancias_hoy = "SELECT SUM(CASE r.tipo_habitacion 
                            WHEN 'Habitación Deluxe' THEN 150 
                            WHEN 'Suite Ejecutiva' THEN 200 
                            WHEN 'Habitación Familiar' THEN 180 
                        END) AS total
                    FROM reservaciones r
                    WHERE DATE(r.fecha_entrada) <= ? AND DATE(r.fecha_salida) >= ?";
$stmt_ganancias_hoy = $conn->prepare($sql_ganancias_hoy);
$stmt_ganancias_hoy->bind_param('ss', $fecha_actual, $fecha_actual);
$stmt_ganancias_hoy->execute();
$result_ganancias_hoy = $stmt_ganancias_hoy->get_result();
$ganancias_hoy = $result_ganancias_hoy->fetch_assoc()['total'] ?? 0;

// Calcular ganancias totales
$sql_ganancias_totales = "SELECT SUM(CASE r.tipo_habitacion 
                            WHEN 'Habitación Deluxe' THEN 150 
                            WHEN 'Suite Ejecutiva' THEN 200 
                            WHEN 'Habitación Familiar' THEN 180 
                        END) AS total
                    FROM reservaciones r";
$result_ganancias_totales = $conn->query($sql_ganancias_totales);
$ganancias_totales = $result_ganancias_totales->fetch_assoc()['total'] ?? 0;

// Obtener información del perfil del administrador
$usuario_id = $_SESSION['usuario_id'];
$sql_perfil = "SELECT nombre, email, imagen_perfil FROM users WHERE id = ?";
$stmt_perfil = $conn->prepare($sql_perfil);
$stmt_perfil->bind_param('i', $usuario_id);
$stmt_perfil->execute();
$result_perfil = $stmt_perfil->get_result();
$perfil = $result_perfil->fetch_assoc();

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

            header("Location: admin_dashboard.php"); // Recargar la página
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
    <title>Dashboard Administrador</title>
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
                    <li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Panel de Administración</h2>

            <!-- Resumen de ganancias -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Ganancias del Día</h5>
                            <p class="card-text display-6">$<?php echo number_format($ganancias_hoy, 2); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <h5 class="card-title">Ganancias Totales</h5>
                            <p class="card-text display-6">$<?php echo number_format($ganancias_totales, 2); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Perfil del administrador -->
            <div class="card mb-4">
                <div class="card-body text-center">
                    <h5 class="card-title">Perfil del Administrador</h5>
                    <div class="mb-3">
                        <img src="<?php echo $perfil['imagen_perfil'] ? 'uploads/' . htmlspecialchars($perfil['imagen_perfil']) : 'https://via.placeholder.com/150'; ?>" alt="Imagen de perfil" class="rounded-circle" style="width: 150px; height: 150px; object-fit: cover;">
                    </div>
                    <h4><?php echo htmlspecialchars($perfil['nombre']); ?></h4>
                    <p><?php echo htmlspecialchars($perfil['email']); ?></p>
                    <form action="admin_dashboard.php" method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="imagen_perfil" class="form-label">Cambiar imagen de perfil</label>
                            <input type="file" class="form-control" id="imagen_perfil" name="imagen_perfil" accept="image/*">
                        </div>
                        <button type="submit" class="btn btn-primary">Subir imagen</button>
                    </form>
                </div>
            </div>

            <!-- Tabla de reservaciones -->
            <h3 class="mt-5">Todas las Reservaciones</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Fecha de Entrada</th>
                        <th>Fecha de Salida</th>
                        <th>Número de Huéspedes</th>
                        <th>Tipo de Habitación</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result_reservaciones->num_rows > 0) { ?>
                        <?php while ($row = $result_reservaciones->fetch_assoc()) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['fecha_entrada']); ?></td>
                                <td><?php echo htmlspecialchars($row['fecha_salida']); ?></td>
                                <td><?php echo htmlspecialchars($row['huespedes']); ?></td>
                                <td><?php echo htmlspecialchars($row['tipo_habitacion']); ?></td>
                                <td>$<?php echo number_format($row['precio'], 2); ?></td>
                                <td>
                                    <a href="edit_reservacion.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-warning">Editar</a>
                                    <a href="admin_dashboard.php?delete_id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de eliminar esta reservación?');">Eliminar</a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="9" class="text-center">No hay reservaciones disponibles</td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
