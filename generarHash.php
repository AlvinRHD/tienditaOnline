<?php
// La contraseña original
$password = "carlos321";

// Generar el hash usando bcrypt (por defecto)
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Mostrar el hash generado
echo "El hash de la contraseña es: " . $hashed_password;
?>
