<?php
require_once '../../config/db.php';
require_once '../../models/Producto.php';
require_once '../../models/Categoria.php';

$productoModel = new Productos($pdo);
$categoriaModel = new Categoria($pdo);

// Si estamos editando, cargamos los datos del producto
$producto = null;
if (isset($_GET['id'])) {
    $producto = $productoModel->getById($_GET['id']);
}

// Cargamos todas las categorías para el desplegable
$categorias = $categoriaModel->getAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $producto ? 'Editar Producto' : 'Crear Producto' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-700 mb-6"><?= $producto ? 'Editar Producto' : 'Crear Producto' ?></h1>
        
        <a href="index.php" class="inline-block text-white bg-gray-500 hover:bg-gray-600 py-2 px-4 rounded-lg shadow-md mb-6">Regresar a Productos</a>
        
        <form action="../../controllers/ProductoController.php" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded-lg shadow-md">
            <input type="hidden" name="action" value="<?= $producto ? 'update' : 'create' ?>">
            <?php if ($producto): ?>
                <input type="hidden" name="id" value="<?= $producto['producto_id'] ?>">
                <input type="hidden" name="imagen_existente" value="<?= $producto['imagen'] ?>">
            <?php endif; ?>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700">Nombre:</label>
                <input type="text" name="nombre" value="<?= $producto['nombre'] ?? '' ?>" required class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700">Descripción:</label>
                <textarea name="descripcion" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg"><?= $producto['descripcion'] ?? '' ?></textarea>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700">Precio:</label>
                <input type="number" name="precio" step="0.01" value="<?= $producto['precio'] ?? '' ?>" required class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700">Cantidad Disponible:</label>
                <input type="number" name="cantidad_disponible" value="<?= $producto['cantidad_disponible'] ?? '' ?>" required class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg">
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700">Categoría:</label>
                <select name="categoria_id" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg">
                    <option value="">Sin categoría</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['categoria_id'] ?>" <?= ($producto['categoria_id'] ?? '') == $categoria['categoria_id'] ? 'selected' : '' ?>>
                            <?= $categoria['nombre_categoria'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-700">Imagen:</label>
                <input type="file" name="imagen" class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-lg">
            </div>
            <?php if (!empty($producto['imagen'])): ?>
                <p class="text-sm">Imagen actual:</p>
                <img src="../../public/images/<?= $producto['imagen'] ?>" alt="Imagen del producto" class="w-32 h-32 object-cover mb-4">
            <?php endif; ?>

            <button type="submit" class="w-full py-2 mt-4 bg-blue-500 text-white rounded-lg hover:bg-blue-600"><?= $producto ? 'Actualizar' : 'Crear' ?></button>
        </form>
    </div>

</body>
</html>