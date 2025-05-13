
<?php
    session_start();

    // Verificar si el usuario ha iniciado sesión
    if (!isset($_SESSION['usuario'])) {  // si la interaccion es diferente a la sesion de un usuario de la base de datos 
        header("Location: ../logout.php"); // te va sacar al login.html
        exit();
    }
      
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="../../styles/main.css">
    <link rel="stylesheet" href="../../styles/solicitud.css">
    <title> SSJ | Solicitudes </title>
</head>
<body>
    
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
                SSJ | Nueva Solicitud
            </h1>

            <div class="formulario">

                <div class="tablas-reg-det">
                    <h3> REGISTRO DE SOLICITUDES (CARTA DE RESIDENCIA): </h3>
                </div>
                <!-- FORMULARIO PARA BUSCAR -->
                <form action="" id="busquedaForm">
                    <b><p> Por favor ingrese los datos solicitados. </p></b>
                    <b><p> Los elementos que tengan un (*) son requeridos obligatoriamente. </p></b><br>

                    <div class="inpt-bx">
                        <label for="cedula" class="labced">Buscar al Censado Solicitante:</label>
                        <input type="text" id="cedula" name="cedula" placeholder="Ingrese Cédula">
                        <button type="button" class="busc" onclick="buscarDatos()"> Buscar </button>
                    </div>
                </form>

                <form action="../crud/create/regis-solicitud.php" method="POST" id="formSolicitud" onsubmit="return validarFormularioSolicitud()">
                    <div class="imgform2">
                        <img src="../../images/2.png">
                    </div>

                    <div class="inpt-bx">
                        <label class="labnom">Cédula:</label>
                        <input type="text" id="ced" name="ced" placeholder="Cédula del Beneficiario" readonly>
                    </div>
                    <div class="inpt-bx">
                        <label class="labnom">Nombre y Apellido:</label>
                        <input type="text" id="nombre_completo" name="nombre_completo" placeholder="Nombre y Apellido del Beneficiario" readonly>
                    </div>
                    <div class="inpt-bx">
                        <label class="labcor">Número de Contacto:</label>
                        <input type="text" id="telefono" name="telefono" placeholder="Contacto del Beneficiario" readonly>
                    </div>
                    <div class="inpt-bx">
                        <label class="labnom">Codigo de Casa:</label>
                        <input type="text" id="direccion" name="direccion" placeholder="Dirección del Beneficiario" readonly>
                    </div>
                    <div class="inpt-bx">
                        <label class="labnom">Calle:</label>
                        <input type="text" id="referido" name="referido" placeholder="Referido del Beneficiario" readonly>
                    </div>
                    <div class="inpt-bx">
                        <label class="labnom">Tiempo Habitando:</label>
                        <input type="text" id="correo" name="correo" placeholder="Correo del Beneficiario" readonly>

                        <label class="labape">Nacionalidad:</label>
                        <input type="text" id="municipio" name="municipio" placeholder="Municipio al que Pertenece el Beneficiario" readonly>
                    </div>
                    <br>
                    <div class="inpt-bx">
                        <label class="labnom">Tipo de Solicitud(*):</label>
                        <input type="text" name="detalles" id="detalles" placeholder="Documentación" value="Documentación" readonly>

                        <label class="labape">Solicitud(*):</label>
                        <input type="text" name="material" id="material" placeholder="Carta de Residencia" value="Carta de Residencia" readonly>
                    </div>
                    <input type="hidden" name="id_beneficiario" value="<?php echo $idBeneficiario; ?>">

                    <b><p> Asegúrese de que los datos ingresados sean correctos. </p></b>
                    <button class="btn-agg" name="registrarsolid"> Solicitar </button>
                </form>

                <script>
                    function buscarDatos() {
                        const cedula = document.getElementById('cedula').value;
                        
                        fetch('buscar.php?cedula=' + cedula)
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Error en la respuesta del servidor');
                                }
                                return response.json();
                            })
                            .then(data => {
                                if (data) {
                                    document.getElementById('ced').value = data.cedula;
                                    document.getElementById('nombre_completo').value = data.nombre_completo;
                                    document.getElementById('telefono').value = data.telefono;
                                    document.getElementById('direccion').value = data.codigo_casa;
                                    document.getElementById('referido').value = data.calle;
                                    document.getElementById('correo').value = data.tiempo_habitado;
                                    document.getElementById('municipio').value = data.nacionalidad;
                                } else {
                                    alert('No se encontraron datos.');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Ha ocurrido un error al buscar los datos.');
                            });
                    }
                </script>
            </div>

        </div>
    </div>

</body>
</html>