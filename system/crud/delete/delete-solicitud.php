
<?php
$conexion = mysqli_connect("localhost", "root", "", "bd_ssj");

// Verificar si hay errores en la conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $idSolicitud = $_GET['id'];
} else {
    echo "ID no válido.";
    exit;
}

$eliminarSQL = "DELETE FROM solicitudes WHERE id = $idSolicitud";

if (mysqli_query($conexion, $eliminarSQL)) {
    echo "<script>alert('¡Solicitud eliminada exitosamente!'); window.location.href = '../read/tab-solicitudes.php';</script>";
    exit();
} else {
    echo "Error al eliminar el censo: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>