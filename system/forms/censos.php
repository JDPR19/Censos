
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
    <title> SSJ | Registrar Censo (Jefe de Familia) </title>
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
                SSJ | Registrar Nuevo Censo (Jefe de Familia)
            </h1>
    
            <div class="formulario">
    
                <div class="tablas-reg-det">
                    <h3> REGISTRO DE NUEVOS CENSOS AL SISTEMA SSJ: </h3>
                    <div>
                        <a href="./habitantes-censo.php"><button class="regre"> Registrar Habitantes </button></a>
                        <a href="../crud/read/tab-censos.php"><button class="regre"> Regresar </button></a>
                    </div>
                </div>
    
                <form action="../crud/create/regis-censo.php" method="POST" onsubmit="return validarFormularioCenso()">
        
                    <b><p> Por favor ingrese los datos solicitados. </p></b>
                    <b><p> Los elementos que tengan un (*) son requeridos obligatoriamente. </p></b><br>

                    <div class="inpt-bx">
                        <label class="labizq">Dirección:</label>
                        <input type="text" name="direccion" id="direccion" placeholder=" Ingrese una dirección">
                    
                        <label class="labder">Calle(*):</label>
                        <select name="sector" required>
                            <option value="0" disabled selected>-- Seleccione --</option>
                            <?php
                                $c = mysqli_query($enlace, "SELECT * FROM calles ");
                                while($sectores = mysqli_fetch_row($c)){
                            ?> 
                            <option value="<?php echo $sectores[1] ?>"><?php echo $sectores[1] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="inpt-bx">
                        <label class="labizq">Codigo de la Casa(*):</label>
                        <input type="text" name="codigo_casa" id="codigo_casa" placeholder=" Ingrese el codigo de la casa" required>

                        <label class="labder">Teléfono:</label>
                        <input type="text" name="telefono" id="telefono" placeholder=" Ingrese un nro. de Teléfono">
                    </div>
                    <div class="inpt-bx">
                        <label class="labizq">Nombre del jefe de familia(*):</label>
                        <input type="text" name="nombre" id="nombre" placeholder=" Ingrese un nombre(s)" required>

                        <label class="labder">Apellido(*):</label>
                        <input type="text" name="apellido" id="apellido" placeholder=" Ingrese un apellido(s)" required>
                    </div>
                    <div class="inpt-bx">
                        <label class="labizq">Cedula(*):</label>
                        <input type="text" name="cedula" id="cedula" placeholder=" Ingrese una cedula" required>

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

                    <button class="btn-agg" name="registrarcenso"> Agregar </button>
    
                </form>
                
            </div>
    
        </div>
    </div>

</body>
</html>