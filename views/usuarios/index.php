<?php
session_start();
// Verificar si el usuario no está logueado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Verificar si el usuario es administrador
if ($_SESSION['rol'] !== 'admin') {
    echo "Acceso denegado. Solo los administradores pueden acceder a esta página.";
    exit;
}

// El contenido para los administradores
echo "<h1>Bienvenido, Administrador</h1>";

require_once '../../config/db.php';
require_once '../../models/Usuario.php';

$usuarioModel = new Usuario($pdo);
$usuarios = $usuarioModel->getAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Usuarios</h1>
        <a href="form.php" class="inline-block text-white bg-green-500 hover:bg-green-600 py-2 px-4 rounded-lg shadow-md mb-6">Añadir Usuario</a>
        <a href="../home/index.php" class="inline-block text-white bg-gray-500 hover:bg-gray-600 py-2 px-4 rounded-lg shadow-md mb-6 ml-4">Regresar al Inicio</a>

        <?php if (!empty($usuarios)): ?>
            <table class="min-w-full bg-white border border-gray-200 shadow-lg rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">ID</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Nombre</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Email</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Rol</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr class="border-b">
                            <td class="py-4 px-6"><?= $usuario['usuario_id'] ?></td>
                            <td class="py-4 px-6"><?= htmlspecialchars($usuario['nombre']) ?></td>
                            <td class="py-4 px-6"><?= htmlspecialchars($usuario['email']) ?></td>
                            <td class="py-4 px-6"><?= htmlspecialchars($usuario['rol']) ?></td>
                            <td class="py-4 px-6">
                                <a href="form.php?id=<?= $usuario['usuario_id'] ?>" class="text-blue-500 hover:text-blue-600">Editar</a>
                                <a href="../../controllers/UsuarioController.php?action=delete&id=<?= $usuario['usuario_id'] ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?')" class="ml-4 text-red-500 hover:text-red-600">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-lg text-gray-600 mt-4">No hay usuarios registrados.</p>
        <?php endif; ?>
    </div>

</body>
</html>
