<?php

$servidor = "localhost";
$usuario = "root";
$clave = "";
$basededatos = "bd_ssj";

$enlace = mysqli_connect($servidor, $usuario, $clave, $basededatos);

if(isset($_POST['registrarcenso'])) {

    $nombre = $_POST['nombre'];
    $apellido = $_POST['apellido'];
    $cedula = $_POST['cedula'];
    $telefono = $_POST['telefono'];
    $tiempo_habitado = $_POST['tiempo_habitado'];
    $sexo = $_POST['sexo'];
    $fechnacim = $_POST['fechnacim'];
    $salud = $_POST['salud'];
    $direccion = $_POST['direccion'];
    $sector = $_POST['sector'];
    $codigo = $_POST['codigo_casa'];
    $profesion = $_POST['profesion'];
    $nacionalidad = $_POST['nacionalidad'];

    // Verificar si el código de la casa ya existe
    $sql_verificar = "SELECT * FROM censo WHERE codigo_casa = '$codigo'";
    $resultado_verificar = mysqli_query($enlace, $sql_verificar);

    if (mysqli_num_rows($resultado_verificar) > 0) {
        echo "<script>alert('Esta casa ya está registrada.'); window.history.back();</script>";
        exit();
    }
    
    // Verificar si la cédula ya existe
    $sql_verificar = "SELECT * FROM censo WHERE cedula = '$cedula'";
    $resultado_verificar = mysqli_query($enlace, $sql_verificar);

    if (mysqli_num_rows($resultado_verificar) > 0) {
        echo "<script>alert('Esta cédula ya está registrada.'); window.history.back();</script>";
        exit();
    }

    $insertarDatos = "INSERT INTO censo VALUES ('', '$nombre', '$apellido', '$cedula', '$telefono', '$tiempo_habitado', '$sexo', '$fechnacim', '$salud', '$direccion', '$sector', '$codigo', '$profesion', 'Jefe de Familia', '$nacionalidad')";

    $ejecutarInsertar = mysqli_query($enlace, $insertarDatos);
    if($ejecutarInsertar) {
        echo "<script>
            if (confirm('¡Registro realizado exitosamente! ¿Quieres registrar los habitantes de este hogar?')) {
                window.location.href = '../../forms/habitantes-censo.php?codigo=$codigo&nombre=$nombre';
            } else {
                window.location.href = '../read/tab-censos.php';
            }
            </script>";
        exit();
    } else {
        echo "Error: " . mysqli_error($enlace);
    }

} elseif (isset($_POST['registrarcensohabit'])) {

    $nombreh = $_POST['nombreh'];
    $apellido = $_POST['apellido'];
    $cedula = $_POST['cedula'];
    $tiempo_habitado = $_POST['tiempo_habitado'];
    $sexo = $_POST['sexo'];
    $fechnacim = $_POST['fechnacim'];
    $salud = $_POST['salud'];
    $profesion = $_POST['profesion'];
    $codigo = $_POST['codigo'];
    $nacionalidad = $_POST['nacionalidad'];

    // Verificar si la cédula ya existe
    $sql_verificar = "SELECT * FROM censo WHERE cedula = '$cedula'";
    $resultado_verificar = mysqli_query($enlace, $sql_verificar);

    if (mysqli_num_rows($resultado_verificar) > 0) {
        echo "<script>alert('Esta cédula ya está registrada.'); window.history.back();</script>";
        exit();
    }

    // Traer datos de la casa y jefe de familia
    $query_jefe = "SELECT direccion, calle, telefono FROM censo WHERE codigo_casa = '$codigo' AND rol = 'Jefe de Familia'";
    $result_jefe = mysqli_query($enlace, $query_jefe);
    if ($row_jefe = mysqli_fetch_assoc($result_jefe)) {
        $direccion = $row_jefe['direccion'];
        $sector = $row_jefe['calle'];
        $telefono = $row_jefe['telefono'];

        $insertarDatos = "INSERT INTO censo VALUES ('', '$nombreh', '$apellido', '$cedula', '$telefono', '$tiempo_habitado', '$sexo', '$fechnacim', '$salud', '$direccion', '$sector', '$codigo', '$profesion', 'Habitante', '$nacionalidad')";
        $ejecutarInsertar = mysqli_query($enlace, $insertarDatos);
        if($ejecutarInsertar) {
            echo "<script>alert('¡Registro realizado exitosamente!'); window.location.href = '../../forms/habitantes-censo.php';</script>";
            exit();
        } else {
            echo "Error: " . mysqli_error($enlace);
        }
    } else {
        echo "<script>alert('Código de casa o cédula del jefe de familia no encontrado.'); window.history.back();</script>";
    }
}

?>
