<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-dark text-white">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h2 class="text-center mb-4">Iniciar Sesión</h2>
                
                <!-- Mostrar mensajes -->
                <?php
                if (isset($_GET['registro']) && $_GET['registro'] == 'exitoso') {
                    echo "<div class='alert alert-success'>Registro exitoso. Ahora puedes iniciar sesión.</div>";
                }
                if (isset($_GET['password_reset']) && $_GET['password_reset'] == 'exitoso') {
                    echo "<div class='alert alert-info'>Contraseña actualizada correctamente. Ahora puedes iniciar sesión.</div>";
                }
                ?>

                <!-- Caja de login -->
                <div class="p-4 rounded border border-white bg-secondary">
                    <form action="procesar_login.php" method="POST">
                        <div class="mb-3">
                            <label for="email" class="form-label">Correo Electrónico:</label>
                            <input type="email" id="email" name="email" class="form-control text-white bg-dark border-white" required>
                        </div>
                        <div class="mb-3">
                            <label for="contraseña" class="form-label">Contraseña:</label>
                            <input type="password" id="contraseña" name="contraseña" class="form-control text-white bg-dark border-white" required>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                            <a href="register.php" class="btn btn-secondary">Ir al Registro</a>
                        </div>
                    </form>
                    <div class="text-center mt-3">
                        <a href="forgot_password.php" class="text-info">¿Olvidaste tu contraseña?</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>