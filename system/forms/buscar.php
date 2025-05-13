<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd_ssj";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (isset($_GET['cedula'])) {
    $cedula = $_GET['cedula'];

    $stmt = $conn->prepare("SELECT cedula, CONCAT(nombre, ' ', apellido) AS nombre_completo, telefono, codigo_casa, calle, tiempo_habitado, nacionalidad FROM censo WHERE cedula = ?");
    $stmt->bind_param("s", $cedula);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(null);
    }

    $stmt->close();
}

$conn->close();
?>
