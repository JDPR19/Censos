<?php
$conexion = mysqli_connect("localhost", "root", "", "bd_ssj");

if (isset($_GET['codcasa'])) {
    $codcasa = mysqli_real_escape_string($conexion, $_GET['codcasa']);

    $query = "SELECT codigo_casa, nombre FROM censo WHERE (codigo_casa = '$codcasa' OR cedula = '$codcasa') AND rol = 'Jefe de Familia'";
    $result = mysqli_query($conexion, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        echo json_encode([
            'success' => true,
            'codigo' => $row['codigo_casa'],
            'nombre_jefe' => $row['nombre']
        ]);
    } else {
        echo json_encode(['success' => false]);
    }
}

mysqli_close($conexion);
?>
