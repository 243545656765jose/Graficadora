<?php
session_start(); // Iniciar la sesión

// Verificar si el usuario está autenticado
if (isset($_SESSION['user'])) {
    // Destruir la sesión
    session_unset(); // Eliminar todas las variables de sesión
    session_destroy(); // Destruir la sesión
}

// Redirigir a la página de inicio de sesión
header("Location: ../../index.php");
exit();
?>
