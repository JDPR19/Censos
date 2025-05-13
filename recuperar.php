<?php
session_start();

// Tarjeta de Coordenadas Pre-Generada
$tarjeta = [
    'A' => ['1' => '12A', '2' => '34B', '3' => '56C', '4' => '78D', '5' => '90E'],
    'B' => ['1' => 'F12', '2' => 'G34', '3' => 'H56', '4' => 'I78', '5' => 'J90'],
    'C' => ['1' => 'K12', '2' => 'L34', '3' => 'M56', '4' => 'N78', '5' => 'O90'],
    'D' => ['1' => 'P12', '2' => 'Q34', '3' => 'R56', '4' => 'S78', '5' => 'T90'],
    'E' => ['1' => 'U12', '2' => 'V34', '3' => 'W56', '4' => 'X78', '5' => 'Y99']
];

// Obtener fila y columna aleatorias
function obtenerPosicionAleatoria() {
    $filas = ['1', '2', '3', '4', '5'];
    $columnas = ['A', 'B', 'C', 'D', 'E'];
    $fila = $filas[array_rand($filas)];
    $columna = $columnas[array_rand($columnas)];
    return [$fila, $columna];
}

if (!isset($_SESSION['fila1']) || !isset($_SESSION['columna1']) || !isset($_SESSION['fila2']) || !isset($_SESSION['columna2'])) {
    list($fila1, $columna1) = obtenerPosicionAleatoria();
    list($fila2, $columna2) = obtenerPosicionAleatoria();

    $_SESSION['tarjeta'] = $tarjeta;
    $_SESSION['fila1'] = $fila1;
    $_SESSION['columna1'] = $columna1;
    $_SESSION['fila2'] = $fila2;
    $_SESSION['columna2'] = $columna2;
} else {
    $fila1 = $_SESSION['fila1'];
    $columna1 = $_SESSION['columna1'];
    $fila2 = $_SESSION['fila2'];
    $columna2 = $_SESSION['columna2'];
}

// Convertir la tarjeta a JSON
$tarjeta_json = json_encode($tarjeta);

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "bd_ssj");

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Autenticación
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $recuperar1 = $_POST['recuperar1'];
    $recuperar2 = $_POST['recuperar2'];

    $correcto1 = $tarjeta[$columna1][$fila1];
    $correcto2 = $tarjeta[$columna2][$fila2];

    // Depuración: Verificar valores
    error_log("Correcto1: $correcto1, Recuperado1: $recuperar1");
    error_log("Correcto2: $correcto2, Recuperado2: $recuperar2");

    if ($recuperar1 === $correcto1 && $recuperar2 === $correcto2) {
        // Consulta para obtener el usuario y contraseña
        $query = "SELECT usuario, passwrd FROM usuario";
        $result = mysqli_query($conexion, $query);

        $usuarios = mysqli_fetch_all($result, MYSQLI_ASSOC);

        // Formatear la información de los usuarios para mostrarla en el alert
        $userString = '';
        foreach ($usuarios as $usuario) {
            $userString .= "Usuario: " . $usuario['usuario'] . "\\nContraseña: " . $usuario['passwrd'] . "\\n\\n";
        }

        // Alert con los datos de los usuarios formateados
        echo "<script>
            alert('Autenticación exitosa. Datos de usuarios:\\n\\n$userString');
        </script>";
    } else {
        echo "<script>alert('Datos incorrectos');</script>";
    }
}
?>

<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="log-styles.css">
    <title>SSJ | Recuperar Credenciales</title>
</head>
<body>
    <div class="container" id="container">      
        <div class="form-container sign-in">
            <form action="" method="POST">
                <div class="social-icons">
                    <img src="" alt="">
                </div>
                <h1>Recuperar Credenciales</h1>
                <br><br>
                <label>Ingrese el dato en <?php echo $columna1 . $fila1; ?>:</label>
                <input type="text" placeholder="Ingrese el dato solicitado aquí" name="recuperar1" required><br>
                <label>Ingrese el dato en <?php echo $columna2 . $fila2; ?>:</label>
                <input type="text" placeholder="Ingrese el dato solicitado aquí" name="recuperar2" required>
                <br>
                <button>Recuperar Credenciales</button>
            </form>
        </div>
        <div class="toggle-container">
            <div class="toggle">
                <div class="toggle-panel toggle-right">
                    <h1>¡Bienvenido de vuelta, usuario!</h1>
                    <p>Ingresa los datos solicitados<br>para acceder al Sistema del<br>Consejo Comunal</p>
                    <p>¿Desea regresar a Iniciar Sesión?</p>
                    <a href="./login.html"><button class="hidden" id="">Iniciar Sesión</button></a>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Mostrar la tarjeta de coordenadas en la consola para verificar
        const tarjeta = <?php echo $tarjeta_json; ?>;
        console.log("Tarjeta de Coordenadas:", tarjeta);
    </script>
    <script src="scripts.js"></script>
</body>
</html>
