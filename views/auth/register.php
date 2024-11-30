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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 w-full max-w-md">
        <h1 class="text-2xl font-bold text-center mb-4 text-gray-700">Regístrate</h1>

        <form action="register.php" method="POST" class="space-y-4">
            <div>
                <label for="nombre" class="block text-gray-700">Nombre</label>
                <input type="text" id="nombre" name="nombre" placeholder="Tu nombre completo" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
            </div>
            <div>
                <label for="email" class="block text-gray-700">Correo Electrónico</label>
                <input type="email" id="email" name="email" placeholder="correo@ejemplo.com" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
            </div>
            <div>
                <label for="direccion" class="block text-gray-700">Dirección</label>
                <input type="text" id="direccion" name="direccion" placeholder="Tu dirección" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
            </div>
            <div>
                <label for="telefono" class="block text-gray-700">Teléfono</label>
                <input type="text" id="telefono" name="telefono" placeholder="123456789" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
            </div>
            <div>
                <label for="password" class="block text-gray-700">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="********" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring focus:ring-blue-200">
            </div>
            <button type="submit" 
                class="w-full bg-red-600 text-white font-bold py-2 px-4 rounded hover:bg-red-700">
                Registrarse
            </button>
        </form>
        <p class="text-sm text-gray-600 mt-4 text-center">
            ¿Ya tienes cuenta? 
            <a href="login.php" class="text-blue-500 hover:underline">Inicia Sesión</a>
        </p>
    </div>
</body>
</html>

