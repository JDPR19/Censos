
<?php
$conexion = mysqli_connect("localhost", "root", "", "bd_ssj");

// Verificar si hay errores en la conexión
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

if (isset($_GET['id'])) {
    $idCenso = $_GET['id'];
} else {
    echo "ID no válido.";
    exit;
}

$eliminarSQL = "DELETE FROM censo WHERE id = $idCenso";

if (mysqli_query($conexion, $eliminarSQL)) {
    echo "<script>alert('¡Censo eliminado exitosamente!'); window.location.href = '../read/tab-censos.php';</script>";
    exit();
} else {
    echo "Error al eliminar el censo: " . mysqli_error($conexion);
}

mysqli_close($conexion);
?>