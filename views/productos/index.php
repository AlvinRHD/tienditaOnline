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
require_once '../../models/Producto.php';

$productoModel = new Productos($pdo);
$productos = $productoModel->getAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Productos</h1>

        <div class="mb-6">
            <a href="form.php" class="inline-block text-white bg-green-500 hover:bg-green-600 py-2 px-4 rounded-lg shadow-md">Añadir Producto</a>
            <a href="../home/index.php" class="inline-block text-white bg-gray-500 hover:bg-gray-600 py-2 px-4 rounded-lg shadow-md ml-4">Regresar al Inicio</a>
        </div>

        <?php if (!empty($productos)): ?>
            <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-2 px-4 border-b">ID</th>
                        <th class="py-2 px-4 border-b">Nombre</th>
                        <th class="py-2 px-4 border-b">Descripción</th>
                        <th class="py-2 px-4 border-b">Precio</th>
                        <th class="py-2 px-4 border-b">Cantidad</th>
                        <th class="py-2 px-4 border-b">Categoría</th>
                        <th class="py-2 px-4 border-b">Imagen</th>
                        <th class="py-2 px-4 border-b">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($productos as $producto): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border-b"><?= $producto['producto_id'] ?></td>
                            <td class="py-2 px-4 border-b"><?= $producto['nombre'] ?></td>
                            <td class="py-2 px-4 border-b"><?= $producto['descripcion'] ?></td>
                            <td class="py-2 px-4 border-b"><?= $producto['precio'] ?></td>
                            <td class="py-2 px-4 border-b"><?= $producto['cantidad_disponible'] ?></td>
                            <td class="py-2 px-4 border-b"><?= $producto['nombre_categoria'] ?? 'Sin categoría' ?></td>
                            <td class="py-2 px-4 border-b"><img src="../../public/image/<?= $producto['imagen'] ?>" alt="Imagen del producto" class="w-16 h-16 object-cover"></td>
                            <td class="py-2 px-4 border-b">
                                <a href="form.php?id=<?= $producto['producto_id'] ?>" class="text-blue-500 hover:text-blue-700">Editar</a> |
                                <a href="../../controllers/ProductoController.php?action=delete&id=<?= $producto['producto_id'] ?>" class="text-red-500 hover:text-red-700" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-gray-700">No hay productos registrados.</p>
        <?php endif; ?>
    </div>

</body>
</html>
