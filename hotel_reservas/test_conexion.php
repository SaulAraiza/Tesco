<?php
// test_conexion.php
// Incluir el archivo de conexión
include 'includes/conexion.php';

// Verificar si la conexión está funcionando
if ($conn->ping()) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Error en la conexión: " . $conn->error;
}

// Cerrar la conexión
$conn->close();
?>