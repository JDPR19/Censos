
<?php
session_start();
session_destroy(); // Destruir la sesión actual
header("Location: ../login.html"); // Redirigir al login
exit();
?>
