<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white"> <!-- Fondo oscuro y texto blanco -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Sing up</h2>
                <!-- Caja de registro -->
                <div class="p-4 rounded border border-white bg-secondary">
                    <form action="procesar_register.php" method="POST">
                        <!-- Campo Nombre -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre:</label>
                            <input type="text" id="nombre" name="nombre" class="form-control text-white bg-dark border-white" placeholder="Ingresa tu nombre" required>
                        </div>
                        <!-- Campo Correo Electrónico -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico:</label>
                            <input type="email" id="email" name="email" class="form-control text-white bg-dark border-white" placeholder="Ingresa tu correo" required>
                        </div>
                        <!-- Campo Contraseña -->
                        <div class="mb-3">
                            <label for="contraseña" class="form-label">Contraseña:</label>
                            <input type="password" id="contraseña" name="contraseña" class="form-control text-white bg-dark border-white" placeholder="Ingresa tu contraseña" required>
                        </div>
                        <!-- Botones -->
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Registrarse</button>
                            <a href="login.php" class="btn btn-danger">Regresar al Login</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS (opcional para interactividad) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>