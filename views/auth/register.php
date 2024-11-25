<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../../config/db.php';

    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $rol = 'cliente'; // Solo clientes se registran a través de este formulario

    // Registrar al usuario en la base de datos
    $stmt = $pdo->prepare("INSERT INTO Usuarios (nombre, email, direccion, telefono, password, rol) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([$nombre, $email, $direccion, $telefono, $password, $rol]);

    echo "<script>alert('Registro exitoso');</script>";
    header("Location: login.php");
    exit;
}
?>

<form action="register.php" method="POST">
    <input type="text" name="nombre" placeholder="Nombre" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="direccion" placeholder="Dirección" required><br>
    <input type="text" name="telefono" placeholder="Teléfono" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <button type="submit">Registrarse</button>
</form>
