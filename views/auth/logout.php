<?php
session_start();  // Asegúrate de iniciar la sesión

// Elimina todas las variables de sesión
session_unset();

// Destruye la sesión
session_destroy();

// Redirige al login
header("Location: login.php");
exit;
?>
