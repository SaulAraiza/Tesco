<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Habitaciones</title>
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
                    <li class="nav-item"><a class="nav-link" href="./contacto.php">Contacto</a></li>
					<li class="nav-item"><a class="nav-link" href="logout.php">Cerrar sesión</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Habitaciones -->
    <section class="py-5">
        <div class="container">
            <h2 class="text-center mb-4">Nuestras habitaciones</h2>
            <div class="row">
                <!-- Habitación Deluxe -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Habitación Deluxe">
                        <div class="card-body">
                            <h5 class="card-title">Habitación Deluxe</h5>
                            <p class="card-text">Confort y lujo, equipada con cama king size, vista al mar y minibar. Ideal para escapadas románticas. <strong>Precio: $150/noche</strong></p>
                            <a href="index.php#reservaciones" class="btn btn-primary">Reservar ahora</a>
                        </div>
                    </div>
                </div>

                <!-- Suite Ejecutiva -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Suite Ejecutiva">
                        <div class="card-body">
                            <h5 class="card-title">Suite Ejecutiva</h5>
                            <p class="card-text">Espacio amplio con escritorio, cafetera, Wi-Fi de alta velocidad y acceso a sala de negocios. <strong>Precio: $200/noche</strong></p>
                            <a href="index.php#reservaciones" class="btn btn-primary">Reservar ahora</a>
                        </div>
                    </div>
                </div>

                <!-- Habitación Familiar -->
                <div class="col-md-4">
                    <div class="card">
                        <img src="https://via.placeholder.com/350x200" class="card-img-top" alt="Habitación Familiar">
                        <div class="card-body">
                            <h5 class="card-title">Habitación Familiar</h5>
                            <p class="card-text">Espacio perfecto para familias, incluye dos camas queen, zona de juegos y servicio de niñera. <strong>Precio: $180/noche</strong></p>
                            <a href="index.php#reservaciones" class="btn btn-primary">Reservar ahora</a>
                        </div>
                    </div>
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
