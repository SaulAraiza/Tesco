<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Recuperar Contraseña</h2>
                <div class="p-4 rounded border border-white bg-secondary">
                    <form action="procesar_forgot_password.php" method="POST">
                        <!-- Campo Correo Electrónico -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico:</label>
                            <input type="email" id="email" name="email" class="form-control text-white bg-dark border-white" placeholder="Ingresa tu correo" required>
                        </div>
                        <!-- Campo Nueva Contraseña -->
                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nueva Contraseña:</label>
                            <input type="password" id="new_password" name="new_password" class="form-control text-white bg-dark border-white" placeholder="Ingresa tu nueva contraseña" required>
                        </div>
                        <!-- Botón Enviar -->
                        <div class="d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Actualizar Contraseña</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>