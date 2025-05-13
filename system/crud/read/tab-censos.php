<?php
$conexion = mysqli_connect("localhost", "root", "", "bd_ssj");

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {  // si la interaccion es diferente a la sesion de un usuario de la base de datos 
    header("Location: ../../logout.php"); // te va sacar al login.html
    exit();
}

$filtro = $_GET['filtro'] ?? 'todos';  // Obtener el valor del filtro, predeterminado a 'todos'
$busqueda = $_GET['busqueda'] ?? '';  // Obtener el término de búsqueda

$query = "SELECT * FROM censo";
$filtrosAplicados = false;
if ($filtro == 'recientes') {
    $query .= " ORDER BY fechnacim DESC";
    $filtrosAplicados = true;
} elseif ($filtro == 'antiguos') {
    $query .= " ORDER BY fechnacim ASC";
    $filtrosAplicados = true;
} elseif ($filtro == 'menores') {
    $query .= " WHERE TIMESTAMPDIFF(YEAR, fechnacim, CURDATE()) < 15";
    $filtrosAplicados = true;
} elseif ($filtro == 'adultos') {
    $query .= " WHERE TIMESTAMPDIFF(YEAR, fechnacim, CURDATE()) > 54";
    $filtrosAplicados = true;
} elseif ($filtro == 'jefefamiliar') {
    $query .= " WHERE rol = 'Jefe de Familia'";
    $filtrosAplicados = true;
} elseif ($filtro == 'calle1') {
    $query .= " WHERE calle = 'Calle 1'";
    $filtrosAplicados = true;
} elseif ($filtro == 'calle2') {
    $query .= " WHERE calle = 'Calle 2'";
    $filtrosAplicados = true;
} elseif ($filtro == 'sector3') {
    $query .= " WHERE calle = 'Calle 3'";
    $filtrosAplicados = true;
} elseif ($filtro == 'calle4') {
    $query .= " WHERE calle = 'Calle 4'";
    $filtrosAplicados = true;
}
 elseif ($filtro == 'calle5') {
    $query .= " WHERE calle = 'Calle 5'";
    $filtrosAplicados = true;
}
elseif ($filtro == 'calle6') {
    $query .= " WHERE calle = 'Calle 6'";
    $filtrosAplicados = true;
}
elseif ($filtro == 'calle7') {
    $query .= " WHERE calle = 'Calle 7'";
    $filtrosAplicados = true;
}
elseif ($filtro == 'calle8') {
    $query .= " WHERE calle = 'Calle 8'";
    $filtrosAplicados = true;
}
elseif ($filtro == 'calle9') {
    $query .= " WHERE calle = 'Calle 9'";
    $filtrosAplicados = true;
}
elseif ($filtro == 'calle10') {
    $query .= " WHERE calle = 'Calle 10'";
    $filtrosAplicados = true;
}
elseif ($filtro == 'calle11') {
    $query .= " WHERE calle = 'Calle 11'";
    $filtrosAplicados = true;
}
elseif ($filtro == 'calle17') {
    $query .= " WHERE calle = 'Calle 17'";
    $filtrosAplicados = true;
}

if (!empty($busqueda)) {
    if ($filtrosAplicados) {
        $query .= " AND ";
    } else {
        $query .= " WHERE ";
    }
    $query .= "nombre LIKE '%" . mysqli_real_escape_string($conexion, $busqueda) . "%' OR apellido LIKE '%" . mysqli_real_escape_string($conexion, $busqueda) . "%' OR cedula LIKE '%" . mysqli_real_escape_string($conexion, $busqueda) . "%' OR codigo_casa LIKE '%" . mysqli_real_escape_string($conexion, $busqueda) . "%' OR direccion LIKE '%" . mysqli_real_escape_string($conexion, $busqueda) . "%'";
}

// Ajuste para ordenar por codigo de casa y rol
if ($filtro != 'recientes' && $filtro != 'antiguos') {
    $query .= " ORDER BY codigo_casa, 
                CASE 
                    WHEN rol = 'Jefe de Familia' THEN 1 
                    ELSE 2 
                END";
}

// Ejecutar la consulta SQL
$result = mysqli_query($conexion, $query);
$num_rows = mysqli_num_rows($result);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../../styles/main.css">
    <link rel="stylesheet" href="../../../styles/tablas.css">
    <title> SSJ | Censos </title>
    <style>
        .jefe-familia {
            background-color:rgba(146, 201, 238, 0.84);
        }
    </style>
</head>
<body>
    
    <div class="wrapper">

        <div class="sidebar">
            <div class="icon"><img src="../../../images/4.jpeg" alt=""></i></div>
            <h2>MENU</h2>
            <ul>
                <li><a href="../../index.php"><i class='bx bxs-paste'></i>INICIO</a></li>
                <li><a href="./tab-censos.php"><i class='bx bxs-building-house'></i>CENSO</a></li>
                <li><a href="../../forms/solicitar-carta.php"><i class='bx bxs-folder-open'></i>CARTA RESIDENCIA</a></li>
                <li><a href="./tab-solicitudes.php"><i class='bx bxs-group'></i>SOLICITUDES</a></li>
            </ul>
            <div class="exit">
              <a href="../../logout.php"><button class="btn-exit"><i class='bx bxs-log-out'></i>Salir</button></a>
            </div>
        </div>

        <div class="tabl">
            <div class="tablas-empl-det">
                <p> SSJ | Censados </p>
                <form id="filtroFormulario" method="GET" action="tab-censos.php">
                    <select name="filtro" class="selct" onchange="this.form.submit()">
                        <option value="" disabled selected>-- Ordenar por: --</option>
                        <option value="todos">Todos</option>
                        <option value="recientes">Recientes</option>
                        <option value="antiguos">Antiguos</option>
                        <option value="menores">Menores de Edad</option>
                        <option value="adultos">Adultos Mayores</option>
                        <option value="jefefamiliar">Jefe de Familia</option>
                        <option value="calle1">Calle 01</option>
                        <option value="calle2">Calle 02</option>
                        <option value="calle3">Calle 03</option>
                        <option value="calle4">Calle 04</option>
                        <option value="calle5">Calle 05</option>
                        <option value="calle6">Calle 06</option>
                        <option value="calle7">Calle 07</option>
                        <option value="calle8">Calle 08</option>
                        <option value="calle9">Calle 09</option>
                        <option value="calle10">Calle 10</option>
                        <option value="calle11">Calle 11</option>
                        <option value="calle17">Calle 17</option>
                    </select>
                </form>
                <form id="buscarFormulario" method="GET" action="tab-censos.php">
                    <input type="text" name="busqueda" class="barra-busc" placeholder="Buscar..." value="<?php echo isset($_GET['busqueda']) ? $_GET['busqueda'] : ''; ?>">
                    <button type="submit" class="busc">Buscar <i class='bx bx-chevron-right-circle'></i></button>
                </form>
                <div>
                    <a href="../../forms/censos.php"><button class="nuev">Nuevo <i class='bx bx-chevron-right-circle'></i></button></a>
                </div>
            </div>
        
            <div class="tablas-proy">
                <table>
                    <thead>
                        <tr>
                            <th>Calle</th>
                            <th>Codigo <br>de Casa</th>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Cedula</th>
                            <th>Sexo</th>
                            <th>Tiempo<br>Habitando</th>
                            <th>Fecha<br>Nacim.</th>
                            <th>Profesión /<br>Ocupación</th>
                            <th>Estado<br>Salud</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($num_rows > 0) {
                            while ($mostrar = mysqli_fetch_array($result)) {
                                // Convertir la fecha de nacimiento al formato DD/MM/YYYY
                                $fechnacim = date("d/m/Y", strtotime($mostrar['fechnacim']));
                                $class = ($mostrar['rol'] == 'Jefe de Familia') ? 'jefe-familia' : '';
                        ?>
                        <tr class="<?php echo $class; ?>">
                            <td> <?php echo $mostrar['calle'] ?> </td>
                            <td> <?php echo $mostrar['codigo_casa'] ?> </td>
                            <td> <?php echo $mostrar['nombre'] ?> </td>
                            <td> <?php echo $mostrar['apellido'] ?> </td>
                            <td> <?php echo $mostrar['cedula'] ?> </td>
                            <td> <?php echo $mostrar['sexo'] ?> </td>
                            <td> <?php echo $mostrar['tiempo_habitado'] ?> </td>
                            <td> <?php echo $fechnacim; ?> </td>
                            <td> <?php echo $mostrar['profesion'] ?> </td>
                            <td> <?php echo $mostrar['salud'] ?> </td>
                            <td>
                                <a href="../update/update-censo.php?id=<?php echo $mostrar['id']; ?>"><button><i class='bx bx-edit-alt'></i></button></a>
                                <a href="../delete/delete-censo.php?id=<?php echo $mostrar['id']; ?>"><button><i class='bx bxs-eraser' onclick="return confirm('¿Estás seguro de que deseas eliminar este censo?')"></i></button></a>
                                <a href="./read-censo.php?id=<?php echo $mostrar['id']; ?>"><button><i class='bx bx-search-alt-2'></i></button></a>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="11" style="text-align: center;">No se encontraron resultados</td>
                        </tr>
                        <?php
                        }
                        mysqli_close($conexion);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>
