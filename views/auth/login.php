<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../../config/db.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Verificar si el usuario existe y es cliente
    $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($password, $usuario['password']) && $usuario['rol'] == 'cliente') {
        $_SESSION['usuario_id'] = $usuario['usuario_id'];
        $_SESSION['rol'] = $usuario['rol'];
        header("Location: ../home/index.php");
        exit;
    } else {
        echo "<script>alert('Credenciales incorrectas o no eres un cliente.');</script>";
    }
}
?>

<form action="login.php" method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Contraseña" required><br>
    <button type="submit">Iniciar sesión</button>
</form>
