<?php
// Configuración de conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bd_ssj";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

date_default_timezone_set('America/Caracas');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recuperar datos del formulario
    $nombresol = $_POST['nombre_completo']; // Nombre y apellido
    $cedulasol = $_POST['ced']; // Cédula del solicitante
    $calle = $_POST['referido']; // Calle

    // Valores predeterminados
    $detalles = "Carta de Residencia"; // Predeterminado
    $estado = "Generada"; // Predeterminado
    $fechacreado = date("Y-m-d"); // Fecha en formato "año-mes-día"

    // Insertar los datos en la base de datos
    $stmt = $conn->prepare("INSERT INTO solicitudes (fechacreado, nombresol, cedulasol, callesol, detalles, estado) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssisss", $fechacreado, $nombresol, $cedulasol, $calle, $detalles, $estado);

    if ($stmt->execute()) {
        echo "<script>alert('Solicitud realizada exitosamente');</script>";

        // Recuperar datos del censado desde la tabla 'censo'
        $stmtCenso = $conn->prepare("SELECT nombre, apellido, nacionalidad, cedula, tiempo_habitado, direccion FROM censo WHERE cedula = ?");
        $stmtCenso->bind_param("s", $cedulasol);
        $stmtCenso->execute();
        $resultCenso = $stmtCenso->get_result();

        if ($resultCenso->num_rows > 0) {
            $data = $resultCenso->fetch_assoc();

            // Construir el nombre completo a partir de los campos 'nombre' y 'apellido'
            $nombre_completo = $data['nombre'] . " " . $data['apellido'];

            // Redirigir al archivo para generar el PDF, pasando los datos necesarios
            header("Location: http://localhost/ssj/fpdf/carta-residencia.php?nombre_completo=" . urlencode($nombre_completo) .
                "&nacionalidad=" . urlencode($data['nacionalidad']) .
                "&cedula=" . urlencode($data['cedula']) .
                "&tiempo_habitado=" . urlencode($data['tiempo_habitado']) .
                "&direccion=" . urlencode($data['direccion']) .
                "&fecha=" . urlencode($fechacreado));
            exit();
        } else {
            echo "<script>alert('No se encontraron datos del censado en la tabla censo.');</script>";
        }
    } else {
        echo "<script>alert('Error al registrar la solicitud.');</script>";
    }

    $stmt->close();
    $stmtCenso->close();
}
$conn->close();
?>
