
<?php
    session_start();

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['usuario'])) {  // si la interaccion es diferente a la sesion de un usuario de la base de datos 
        header("Location: ../login.html"); // te va sacar al login.html
        exit();
    }
      
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../styles/main.css">
    <title> SSJ | Principal </title>
</head>
<body>
    
    <div class="wrapper">

        <div class="sidebar">
            <div class=""><img src="../images/4.jpeg" alt=""></i></div>
            <h2>MENU</h2>
            <ul>
                <li><a href="./index.php"><i class='bx bxs-paste'></i>INICIO</a></li>
                <li><a href="./crud/read/tab-censos.php"><i class='bx bxs-building-house'></i>CENSO</a></li>
                <li><a href="./forms/solicitar-carta.php"><i class='bx bxs-folder-open'></i>CARTA RESIDENCIA</a></li>
                <li><a href="./crud/read/tab-solicitudes.php"><i class='bx bxs-group'></i>SOLICITUDES</a></li>
            </ul>
            <div class="exit">
              <a href="./logout.php"><button class="btn-exit"><i class='bx bxs-log-out'></i>Salir</button></a>
            </div>
        </div>
        <div class="main-content">

            <h1>
               SSJ  |  Urbanización San José  
            </h1>
    
            <div class="img1">
                <img src="../images/1.jpeg" alt="">
                <div class="container">
                    <div class="tamaño-de-fuente">
                        <p> <b>Misión: </b> Promover y consolidar la democracia participativa y protagónica,  mediante la promoción y el fortalecimiento de todas aquellas exposiciones organizativas y comunitarias que propicien el ejercicio de la corresponsabilidad social en la gestión pública.
                            <br> <br> <b>Visión: </b>  Toda comunidad se basa en el trabajo de un conjunto de personas y se torna necesario en orientar el comportamiento de ese individuo integrado y dirigirlo rumbo a los objetivos comunales. Es por ello  que los esfuerzos de los seres y todas las actividades de los diversos sectores deberán ser conjugados e integrados para el pleno alcance y rendimiento de la comunidad. 
                        </p>   
                    </div>
                </div>
            </div>
    
        </div>
    </div>

</body>
</html>