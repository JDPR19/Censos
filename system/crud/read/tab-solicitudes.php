
<?php
// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "bd_ssj");

session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {  // si la interaccion es diferente a la sesion de un usuario de la base de datos 
    header("Location: ../../logout.php"); // te va sacar al login.html
    exit();
}

$filtro = $_GET['filtro'] ?? 'todos';  // Obtener el valor del filtro, predeterminado a 'todos'
$busqueda = $_GET['busqueda'] ?? '';  // Obtener el término de búsqueda

$query = "SELECT * FROM solicitudes";
if ($filtro == 'recientes') {
    $query .= " ORDER BY fechacreado DESC";
} elseif ($filtro == 'antiguos') {
    $query .= " ORDER BY fechacreado ASC";
} elseif ($filtro == 'rechazados') {
    $query .= " WHERE estado='Rechazado'";
}

if (!empty($busqueda)) {
    $query .= $filtro != 'todos' ? " AND " : " WHERE ";
    $query .= "nombresol LIKE '%" . mysqli_real_escape_string($conexion, $busqueda) . "%' OR detalles LIKE '%" . mysqli_real_escape_string($conexion, $busqueda) . "%'OR cedulasol LIKE '%" . mysqli_real_escape_string($conexion, $busqueda) . "%'";
}

// Ejecutar la consulta SQL
$result = mysqli_query($conexion, $query);
$num_rows = mysqli_num_rows($result);

// Rechazar proyecto
if (isset($_POST['rechazado'])) {
    $IDproy = $_GET['id'];

    // Actualizar estado del proyecto a 'Rechazado'
    $sql = "UPDATE solicitudes SET estado='Rechazado' WHERE id='$IDproy'";
    mysqli_query($conexion, $sql);

    // Si se confirmó eliminar, eliminar el proyecto
    if (isset($_POST['eliminarproy'])) {
        header("Location: ../delete/delete-solicitud.php?id=$IDproy");
        exit();
    } else {
        // Redireccionar a la página de proyectos
        header("Location: tab-solicitudes.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../../styles/main.css">
    <link rel="stylesheet" href="../../../styles/tablas.css">
    <title> SSJ | Solicitudes </title>
    <script>
        function confirmarRechazo(form) {
                if (confirm('¿Estás seguro de que deseas rechazar este proyecto?')) {
                    if (confirm('¿Quieres eliminar este proyecto de la base de datos?')) {
                        form.appendChild(createHiddenInput('eliminarproy', true));
                    }
                    return true;
                }
            return false;
        }
        function createHiddenInput(name, value) {
            var input = document.createElement('input');
                input.type = 'hidden';
                input.name = name;
                input.value = value;
            return input;
        }
    </script>
    <style>
        .button-container {
            display: flex;
            gap: 2px; /* Espacio entre botones */
            justify-content: center;
        }

        .button-container form,
        .button-container a {
            margin: 0;
        }
        
        .estado-aprobado {
            background-color: #52BE80;
            color: #1B2631;
            font-weight: bold;
            letter-spacing: 1px;
            border: none;
        }
        tr:hover .estado-aprobado{
            background-color: #47a771;
            color: #FFF;
            font-weight: bold;
            letter-spacing: 1px;
            border: none;
        }
        .estado-pendiente {
            background-color: #F4D03F;
            color: #1B2631;
            font-weight: bold;
            letter-spacing: 1px;
            border: none;
        }
        tr:hover .estado-pendiente{
            background-color: #dbbb39;
            color: #FFF;
            font-weight: bold;
            letter-spacing: 1px;
            border: none;
        }
        .estado-rechazado {
            background-color: #EC7063;
            color: #1B2631;
            font-weight: bold;
            letter-spacing: 1px;
            border: none;
        }
        tr:hover .estado-rechazado{
            background-color: #ca6458;
            color: #FFF;
            font-weight: bold;
            letter-spacing: 1px;
            border: none;
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
                <p> SSJ | Solicitudes Realizadas </p>
                <form id="filtroFormulario" method="GET" action="tab-solicitudes.php">
                    <select name="filtro" class="selct" onchange="this.form.submit()">
                        <option value="" disabled selected>-- Ordenar por: --</option>
                        <option value="todos">Todos</option>
                        <option value="recientes">Recientes</option>
                        <option value="antiguos">Antiguos</option>
                        <option value="rechazados">Rechazados</option>
                    </select>
                </form>
                <form id="buscarFormulario" method="GET" action="tab-solicitudes.php">
                    <input type="text" name="busqueda" class="barra-busc" placeholder="Buscar..." value="<?php echo isset($_GET['busqueda']) ? $_GET['busqueda'] : ''; ?>">
                    <button type="submit" class="busc">Buscar <i class='bx bx-chevron-right-circle'></i></button>
                </form>
                <div>
                    <a href="../../forms/solicitar-carta.php"><button class="nuev">Nuevo <i class='bx bx-chevron-right-circle'></i></button></a>
                </div>
            </div>
        
            <div class="tablas-proy">
                <table>

                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha de <br> Solicitud</th>
                            <th>Nombre del <br> Solicitante</th>
                            <th>Cedula del <br> Solicitante</th>
                            <th>Calle del <br> Solicitante</th>
                            <th>Tipo de <br> Solicitud</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($num_rows > 0) {
                            while ($mostrar = mysqli_fetch_array($result)) {
                                $estadoClass = '';
                                if ($mostrar['estado'] == 'Generada') {
                                    $estadoClass = 'estado-aprobado';
                                } elseif ($mostrar['estado'] == 'Pendiente') {
                                    $estadoClass = 'estado-pendiente';
                                } elseif ($mostrar['estado'] == 'Rechazado') {
                                    $estadoClass = 'estado-rechazado';
                                }

                                // Convertir la fecha de creación y fecha de reunión al formato DD/MM/YYYY
                                $fechacreado = date("d/m/Y", strtotime($mostrar['fechacreado']));
                        ?>
                        <tr>
                            <td> <?php echo $mostrar['id']; ?> </td>
                            <td> <?php echo $fechacreado; ?> </td>
                            <td> <?php echo $mostrar['nombresol']; ?> </td>
                            <td> <?php echo $mostrar['cedulasol']; ?> </td>
                            <td> <?php echo $mostrar['callesol']; ?> </td>
                            <td> <?php echo $mostrar['detalles']; ?> </td>
                            <td class="<?php echo $estadoClass; ?>"> <?php echo $mostrar['estado']; ?> </td>
                            <td>
                                <?php if ($mostrar['estado'] != 'Aprobado') { ?>
                                    <div class="button-container">
                                        <form method="post" action="tab-solicitudes.php?id=<?php echo $mostrar['id']; ?>" onsubmit="return confirmarRechazo(this);" style="display:inline;">
                                            <button type="submit" name="rechazado" class="deng"><i class='bx bxs-x-circle'></i></button>
                                        </form>
                                    </div>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                        ?>
                        <tr>
                            <td colspan="8" style="text-align: center;">No se encontraron resultados</td>
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