<?php
require_once '../../config/db.php';
require_once '../../models/Usuario.php';

$usuarioModel = new Usuario($pdo);

// Si se está editando, cargamos los datos del usuario
$usuario = null;
if (isset($_GET['id'])) {
    $usuario = $usuarioModel->getById($_GET['id']);
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $usuario ? 'Editar Usuario' : 'Crear Usuario' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-700 mb-6"><?= $usuario ? 'Editar Usuario' : 'Crear Usuario' ?></h1>
        <a href="index.php" class="inline-block text-white bg-gray-500 hover:bg-gray-600 py-2 px-4 rounded-lg shadow-md mb-6">Regresar a usuarios</a>

        <!-- Formulario centrado y ajustado en el ancho -->
        <form action="../../controllers/UsuarioController.php" method="POST" class="bg-white p-6 rounded-lg shadow-md max-w-lg mx-auto">
            <input type="hidden" name="action" value="<?= $usuario ? 'update' : 'create' ?>">
            <?php if ($usuario): ?>
                <input type="hidden" name="id" value="<?= $usuario['usuario_id'] ?>">
            <?php endif; ?>

            <label for="nombre" class="block text-gray-600 font-semibold mb-2">Nombre:</label>
            <input type="text" name="nombre" value="<?= $usuario['nombre'] ?? '' ?>" required class="w-full p-3 mb-4 border border-gray-300 rounded-md">

            <label for="email" class="block text-gray-600 font-semibold mb-2">Email:</label>
            <input type="email" name="email" value="<?= $usuario['email'] ?? '' ?>" required class="w-full p-3 mb-4 border border-gray-300 rounded-md">

            <label for="direccion" class="block text-gray-600 font-semibold mb-2">Dirección:</label>
            <input type="text" name="direccion" value="<?= $usuario['direccion'] ?? '' ?>" class="w-full p-3 mb-4 border border-gray-300 rounded-md">

            <label for="telefono" class="block text-gray-600 font-semibold mb-2">Teléfono:</label>
            <input type="text" name="telefono" value="<?= $usuario['telefono'] ?? '' ?>" class="w-full p-3 mb-4 border border-gray-300 rounded-md">

            <label for="password" class="block text-gray-600 font-semibold mb-2">Contraseña:</label>
            <input type="password" name="password" <?= $usuario ? '' : 'required' ?> class="w-full p-3 mb-4 border border-gray-300 rounded-md">

            <label for="rol" class="block text-gray-600 font-semibold mb-2">Rol:</label>
            <select name="rol" required class="w-full p-3 mb-4 border border-gray-300 rounded-md">
                <option value="cliente" <?= ($usuario['rol'] ?? '') === 'cliente' ? 'selected' : '' ?>>Cliente</option>
                <option value="admin" <?= ($usuario['rol'] ?? '') === 'admin' ? 'selected' : '' ?>>Administrador</option>
            </select>

            <button type="submit" class="w-full py-3 px-4 bg-blue-500 hover:bg-blue-600 text-white rounded-lg"> <?= $usuario ? 'Actualizar' : 'Crear' ?></button>
        </form>
    </div>

</body>
</html>

