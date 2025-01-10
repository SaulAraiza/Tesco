<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - TESCO Beaches</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo_login.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="text-center mb-4">Iniciar Sesión</h1>

                        <!-- Área de mensajes de error -->
                        <?php
                        if (isset($_GET['error'])) {
                            echo '<div class="alert alert-danger text-center">' . htmlspecialchars($_GET['error']) . '</div>';
                        }
                        ?>

                        <!-- Formulario -->
                        <form action="login.php" method="POST">
                            <!-- Campo Correo -->
                            <div class="mb-3">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" placeholder="Ingresa tu correo" required>
                            </div>
                            <!-- Campo Contraseña -->
                            <div class="mb-3">
                                <label for="contrasena" class="form-label">Contraseña</label>
                                <input type="password" class="form-control" id="contrasena" name="contrasena" placeholder="Ingresa tu contraseña" required>
                            </div>
                            <!-- Botón de inicio de sesión -->
                            <button type="submit" class="btn btn-primary w-100">Iniciar Sesión</button>
                        </form>
                        <!-- Enlace para registrarse -->
                        <div class="mt-3 text-center">
                            <p>¿No tienes una cuenta? <a href="registro.html">Regístrate</a></p>
                        </div>
                        <!-- Enlace para recuperar contraseña -->
                        <div class="mt-3 text-center">
                            <p><a href="recuperar.html">¿Olvidaste tu contraseña?</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
