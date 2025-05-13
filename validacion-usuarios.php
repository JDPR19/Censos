
<?php
session_start(); // Iniciar sesión

// Conexión a la base de datos
$conexion = mysqli_connect("localhost", "root", "", "bd_ssj");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = mysqli_real_escape_string($conexion, $_POST['user']);
    $passwrd = mysqli_real_escape_string($conexion, $_POST['passwrd']);
    
    // Consulta para verificar el usuario
    $query = "SELECT * FROM usuario WHERE usuario = '$usuario' AND passwrd = '$passwrd'";
    $result = mysqli_query($conexion, $query);
    
    if (mysqli_num_rows($result) == 1) {
        // Usuario y contraseña correctos
        $_SESSION['usuario'] = $usuario; // Almacenar el usuario en la sesión
        echo "<script>alert('¡Bienvenido, Usuario!');</script>";
        header("Location: ./system/load.html"); // Redirigir a la página principal
        
        exit();
    } else {
        // Usuario o contraseña incorrectos
        echo "<script>alert('¡Usuario o contraseña incorrecto!'); window.history.back();</script>";
    }
}

mysqli_close($conexion);
?>
