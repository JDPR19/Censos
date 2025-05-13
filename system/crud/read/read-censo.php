<?php

    $servidor = "localhost";
    $usuario = "root";
    $clave = "";
    $basededatos = "bd_ssj";

    $enlace = mysqli_connect($servidor, $usuario, $clave, $basededatos);

    session_start();

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['usuario'])) {  // si la interaccion es diferente a la sesion de un usuario de la base de datos 
        header("Location: ../../logout.php"); // te va sacar al login.html
        exit();
    }

    $idCenso = $_GET['id'];
    
    $sql = "SELECT * FROM censo WHERE id = '$idCenso'";
    $result = mysqli_query($enlace, $sql);
    $censo = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../../styles/main.css">
    <link rel="stylesheet" href="../../../styles/forms.css">
    <title> SSJ | Verificar Censo (Jefe de Familia) </title>
    <script src="../../scripts/validaciones-censo.js"></script>
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
            <div class="icon"><img src="../../../images/4.jpeg" alt=""></i></div>
            <h2>MENU</h2>
            <ul>
                <li><a href="../index.php"><i class='bx bxs-paste'></i>INICIO</a></li>
                <li><a href="../read/tab-censos.php"><i class='bx bxs-building-house'></i>CENSO</a></li>
                <li><a href="../forms/solicitar-carta.php"><i class='bx bxs-folder-open'></i>CARTA RESIDENCIA</a></li>
                <li><a href="../crud/read/tab-solicitudes.php"><i class='bx bxs-group'></i>SOLICITUDES</a></li>
            </ul>
            <div class="exit">
              <a href="../../logout.php"><button class="btn-exit"><i class='bx bxs-log-out'></i>Salir</button></a>
            </div>
        </div>
        <div class="main-content">

            <h1>
                SSJ | Verificar Censo
            </h1>
    
            <div class="formulario">
    
                <div class="tablas-reg-det">
                    <h3> REGISTRO DE NUEVOS CENSOS AL SISTEMA SSJ: </h3>
                    <div>
                        <a href="../read/tab-censos.php"><button class="regre"> Regresar </button></a>
                    </div>
                </div>
    
                <form action="" method="">
        
                    <b><p> Por favor ingrese los datos solicitados. </p></b>
                    <b><p> Los elementos que tengan un (*) son requeridos obligatoriamente. </p></b><br>

                    <div class="inpt-bx">
                        <label class="labizq">Dirección:</label>
                        <input type="text" name="direccion" id="direccion" placeholder=" Ingrese una dirección" value="<?= $censo['direccion'] ?>" readonly>
                    
                        <label class="labder">Calle(*):</label>
                        <input type="text" name="sectore" id="sector" placeholder=" Ingrese el sector" value="<?= $censo['calle'] ?>" readonly>
                    </div>
                    <div class="inpt-bx">
                        <label class="labizq">Codigo de la Casa(*):</label>
                        <input type="text" name="codigo_casa" id="codigo_casa" placeholder=" Ingrese el codigo de la casa" value="<?= $censo['codigo_casa'] ?>" readonly>

                        <label class="labder">Teléfono:</label>
                        <input type="text" name="telefono" id="telefono" placeholder=" Ingrese un nro. de Teléfono" value="<?= $censo['telefono'] ?>" readonly>
                    </div>
                    <div class="inpt-bx">
                        <label class="labizq">Nombre del jefe de familia(*):</label>
                        <input type="text" name="nombre" id="nombre" placeholder=" Ingrese un nombre(s)" value="<?= $censo['nombre'] ?>" readonly>

                        <label class="labder">Apellido(*):</label>
                        <input type="text" name="apellido" id="apellido" placeholder=" Ingrese un apellido(s)" value="<?= $censo['apellido'] ?>" readonly>
                    </div>
                    <div class="inpt-bx">
                        <label class="labizq">Cedula(*):</label>
                        <input type="text" name="cedula" id="cedula" placeholder=" Ingrese una cedula" value="<?= $censo['cedula'] ?>" readonly>

                        <label class="labder">Sexo(*):</label>
                        <input type="text" name="sexo" id="sexo" placeholder=" Ingrese el sexo" value="<?= $censo['sexo'] ?>" readonly>
                    </div>
                    <div class="inpt-bx">
                        <label class="labizq">Tiempo Habitando:</label>
                        <input type="text" name="tiempo_habitado" id="tiempo_habitado" placeholder=" Ingrese el tiempo habitado en años" value="<?= $censo['tiempo_habitado'] ?>" readonly>
                    
                        <label class="labder">Profesión u Ocupación:</label>
                        <input type="text" name="profesion" id="profesion" placeholder=" Ingrese la profesion u ocupacion" value="<?= $censo['profesion'] ?>" readonly>
                    
                    </div>
                    <div class="inpt-bx">
                        <label class="labizq-baj">Fecha de Nacimiento:</label><br>
                        <input name="fechnacime" id="fechnacim" type="date" value="<?= $censo['fechnacim'] ?>" readonly>

                        <label class="labder-baj">Discapacidad:</label>
                        <input type="text" name="salud" id="salud" placeholder=" Ingrese el estado de salud" value="<?= $censo['salud'] ?>" readonly>
                    </div>    
                    <br>
                    <b><p> Asegurese de que los datos ingresados sean correctos. </p></b>

                    <a href="./tab-censos.php"><button class="btn-agg" name="registrarcenso"> Agregar </button></a>
    
                </form>
                
            </div>
    
        </div>
    </div>

</body>
</html>