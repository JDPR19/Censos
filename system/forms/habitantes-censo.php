
<?php
    session_start();

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['usuario'])) {  // si la interaccion es diferente a la sesion de un usuario de la base de datos 
        header("Location: ../logout.html"); // te va sacar al login.html
        exit();
    }
      
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../styles/main.css">
    <link rel="stylesheet" href="../../styles/forms.css">
    <title> SSJ | Registrar Censo (Habitantes) </title>
    <script src="../../scripts/validaciones-censo.js"></script>
    <script>
        function buscarDatos() {
            const codcasaInput = document.getElementById('codcasa').value;
            
            fetch(`./buscar-datos-jefe.php?codcasa=${codcasaInput}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('codigo').value = data.codigo;
                        document.getElementById('nombre').value = data.nombre_jefe;
                    } else {
                        alert("Código de casa o cédula del jefe de familia no encontrado.");
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</head>
<body>
    
    <?php
        $servidor = "localhost";
        $usuario = "root";
        $clave = "";
        $basededatos = "bd_ssj";
    
        $enlace = mysqli_connect($servidor, $usuario, $clave, $basededatos);
    ?>

    <div class="wrapper">

        <div class="sidebar">
            <div class="icon"><img src="../../images/4.jpeg" alt=""></i></div>
            <h2>MENU</h2>
            <ul>
                <li><a href="../index.php"><i class='bx bxs-paste'></i>INICIO</a></li>
                <li><a href="../crud/read/tab-censos.php"><i class='bx bxs-building-house'></i>CENSO</a></li>
                <li><a href="../forms/solicitar-carta.php"><i class='bx bxs-folder-open'></i>CARTA RESIDENCIA</a></li>
                <li><a href="../crud/read/tab-solicitudes.php"><i class='bx bxs-group'></i>SOLICITUDES</a></li>
            </ul>
            <div class="exit">
              <a href="../logout.php"><button class="btn-exit"><i class='bx bxs-log-out'></i>Salir</button></a>
            </div>
        </div>
        <div class="main-content">

            <h1>
                SSJ | Registrar Nuevo Censo (Habitantes)
            </h1>
    
            <div class="formulario">
                <div class="tablas-reg-det">
                    <h3> REGISTRO DE NUEVOS CENSOS AL SISTEMA SSJ: </h3>
                    <div>
                        <a href="./censos.php"><button class="regre"> Registrar Jefe de Familia </button></a>
                        <a href="../crud/read/tab-censos.php"><button class="regre"> Regresar </button></a>
                    </div>
                </div>
                <!-- FORMULARIO PARA BUSCAR -->
                <form action="" id="busquedaForm">
                    <b><p> Por favor ingrese los datos solicitados. </p></b>
                    <b><p> Los elementos que tengan un (*) son requeridos obligatoriamente. </p></b><br>

                    <div class="inpt-bx">
                        <label for="codcasa" class="labizq">Codigo de la Casa ó Cedula del Jefe de Familia:</label>
                        <input type="text" id="codcasa" name="codcasa" placeholder="Ingrese el dato solicitado">
                        <button type="button" class="busc" onclick="buscarDatos()"> Buscar <i class='bx bx-search-alt'></i> </button>
                    </div>
                </form>

                <form action="../crud/create/regis-censo.php" method="POST" onsubmit="return validarFormularioCenso()">
                    <?php
                        if (isset($_GET['codigo']) && isset($_GET['nombre'])) {
                            $codigo = $_GET['codigo'];
                            $nombre = $_GET['nombre'];
                        } else {
                            $codigo = '';
                            $nombre = '';
                        }
                    ?>
                    <div class="inpt-bx">
                        <label class="labizq">Codigo de la Casa(*):</label>
                        <input type="text" name="codigo" id="codigo" value="<?php echo $codigo; ?>" placeholder=" Ingrese el codigo de la casa" readonly>

                        <label class="labder">Nombre del jefe de familia(*):</label>
                        <input type="text" name="nombre" id="nombre" value="<?php echo $nombre; ?>" placeholder=" Ingrese un nombre(s)" readonly>
                    </div>
                    <div class="inpt-bx">
                        <label class="labizq">Nombre del habitante:</label>
                        <input type="text" name="nombreh" id="nombreh" placeholder=" Ingrese un nombre(s)">

                        <label class="labder">Apellido(*):</label>
                        <input type="text" name="apellido" id="apellido" placeholder=" Ingrese un apellido(s)">
                    </div>
                    <div class="inpt-bx">
                        <label class="labizq">Cedula(*):</label>
                        <input type="text" name="cedula" id="cedula" placeholder=" Ingrese una cedula">

                        <label class="labder">Sexo(*):</label>
                        <select name="sexo" required>
                            <option value="0" disabled selected>-- Seleccione --</option>
                            <?php
                                $a = mysqli_query($enlace, "SELECT * FROM sexo ");
                                while($sexo = mysqli_fetch_row($a)){
                            ?> 
                            <option value="<?php echo $sexo[1] ?>"><?php echo $sexo[1] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="inpt-bx">
                        <label class="labizq">Tiempo Habitando en Años(*):</label>
                        <input type="text" name="tiempo_habitado" id="tiempo_habitado" placeholder=" Ingrese el tiempo habitado en años" required>
                    
                        <label class="labder">Nacionalidad:</label>
                        <select name="nacionalidad">
                            <option value="0" disabled selected>-- Seleccione --</option>
                            <?php
                                $z = mysqli_query($enlace, "SELECT * FROM nacionalidad ");
                                while($profesion = mysqli_fetch_row($z)){
                            ?> 
                            <option value="<?php echo $profesion[1] ?>"><?php echo $profesion[1] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="inpt-bx">
                        <label class="labizq-baj">Fecha de Nacimiento:</label><br>
                        <input type="date" id="fechnacim" name="fechnacim">

                        <label class="labder-baj">Profesión u Ocupación:</label>
                        <select name="profesion">
                            <option value="0" disabled selected>-- Seleccione --</option>
                            <?php
                                $d = mysqli_query($enlace, "SELECT * FROM profesion ");
                                while($profesion = mysqli_fetch_row($d)){
                            ?> 
                            <option value="<?php echo $profesion[1] ?>"><?php echo $profesion[1] ?></option>
                            <?php } ?>
                        </select>
                    </div>    
                    <div class="inpt-bx">
                        <label class="labizq">Discapacidad:</label>
                        <select name="salud">
                            <option value="0" disabled selected>-- Seleccione --</option>
                            <?php
                                $b = mysqli_query($enlace, "SELECT * FROM salud ");
                                while($salud = mysqli_fetch_row($b)){
                            ?> 
                            <option value="<?php echo $salud[1] ?>"><?php echo $salud[1] ?></option>
                            <?php } ?>
                        </select>
                    </div>  
                    <br>
                    <b><p> Asegurese de que los datos ingresados sean correctos. </p></b>

                    <button class="btn-agg" name="registrarcensohabit"> Agregar </button>

                </form>
            </div>

        </div>
    </div>

</body>
</html>