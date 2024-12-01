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
require_once '../../models/Categoria.php';

$categoriaModel = new Categoria($pdo);
$categorias = $categoriaModel->getAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorías</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Categorías</h1>

        <a href="form.php" class="inline-block mb-4 text-white bg-green-500 hover:bg-green-600 py-2 px-4 rounded-lg shadow-md">Añadir Categoría</a>
        <a href="../home/index.php" class="inline-block mb-4 ml-4 text-white bg-gray-500 hover:bg-gray-600 py-2 px-4 rounded-lg shadow-md">Regresar al Inicio</a>

        <table class="min-w-full bg-white border border-gray-200 shadow-lg rounded-lg mb-6">
            <thead class="bg-gray-100">
                <tr>
                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">ID</th>
                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Nombre</th>
                    <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categorias as $categoria): ?>
                    <tr class="border-b">
                        <td class="py-4 px-6"><?= $categoria['categoria_id'] ?></td>
                        <td class="py-4 px-6"><?= $categoria['nombre_categoria'] ?></td>
                        <td class="py-4 px-6">
                            <a href="form.php?id=<?= $categoria['categoria_id'] ?>" class="text-blue-600 hover:text-blue-700">Editar</a> |
                            <a href="../../controllers/CategoriaController.php?action=delete&id=<?= $categoria['categoria_id'] ?>" class="text-red-600 hover:text-red-700" onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

</body>
</html>

