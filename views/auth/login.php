<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Asegúrate de que session_start() se llame antes de cualquier otra cosa
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once '../../config/db.php';

    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        // Verificar si el usuario existe
        $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE email = ?");
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario && password_verify($password, $usuario['password'])) {
            $_SESSION['usuario_id'] = $usuario['usuario_id'];
            $_SESSION['rol'] = $usuario['rol'];
            if ($usuario['rol'] === 'admin') {
                header("Location: ../home/index.php");
            } elseif ($usuario['rol'] === 'cliente') {
                header("Location: ../home/index.php");
            }
            exit;
        } else {
            echo "<script>alert('Credenciales incorrectas.');</script>";
        }
    } catch (PDOException $e) {
        die("Error al procesar la solicitud: " . $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-4 text-gray-700">Iniciar Sesión</h1>
        
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <p class="text-red-500 text-center mb-4">Credenciales incorrectas.</p>
        <?php endif; ?>

        <form action="login.php" method="POST" class="space-y-4">
            <div>
                <label for="email" class="block text-gray-700">Correo Electrónico</label>
                <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
            </div>
            <div>
                <label for="password" class="block text-gray-700">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="********" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
            </div>
            <button type="submit" 
                class="w-full bg-red-600 text-white font-bold py-2 px-4 rounded hover:bg-red-700">
                Iniciar Sesión
            </button>
        </form>
        <p class="text-sm text-gray-600 mt-4 text-center">
            ¿No tienes cuenta? 
            <a href="register.php" class="text-blue-500 hover:underline">Regístrate aquí</a>
        </p>
    </div>
</body>
</html>


