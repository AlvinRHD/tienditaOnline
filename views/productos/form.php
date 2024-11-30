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
<html>
<head>
    <title><?= $producto ? 'Editar Producto' : 'Crear Producto' ?></title>
</head>
<h1>Formulario de Producto</h1>
<a href="index.php">Regresar a Productos</a>
<body>
    <h1><?= $producto ? 'Editar Producto' : 'Crear Producto' ?></h1>
    <form action="../../controllers/ProductoController.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="action" value="<?= $producto ? 'update' : 'create' ?>">
    <?php if ($producto): ?>
        <input type="hidden" name="id" value="<?= $producto['producto_id'] ?>">
        <input type="hidden" name="imagen_existente" value="<?= $producto['imagen'] ?>">
    <?php endif; ?>
    
    <label>Nombre:</label>
    <input type="text" name="nombre" value="<?= $producto['nombre'] ?? '' ?>" required><br>

    <label>Descripción:</label>
    <textarea name="descripcion"><?= $producto['descripcion'] ?? '' ?></textarea><br>

    <label>Precio:</label>
    <input type="number" name="precio" step="0.01" value="<?= $producto['precio'] ?? '' ?>" required><br>

    <label>Cantidad Disponible:</label>
    <input type="number" name="cantidad_disponible" value="<?= $producto['cantidad_disponible'] ?? '' ?>" required><br>

    <label>Categoría:</label>
    <select name="categoria_id">
        <option value="">Sin categoría</option>
        <?php foreach ($categorias as $categoria): ?>
            <option value="<?= $categoria['categoria_id'] ?>" <?= ($producto['categoria_id'] ?? '') == $categoria['categoria_id'] ? 'selected' : '' ?>>
                <?= $categoria['nombre_categoria'] ?>
            </option>
        <?php endforeach; ?>
    </select><br>

    <label>Imagen:</label>
    <input type="file" name="imagen"><br>
    <?php if (!empty($producto['imagen'])): ?>
        <p>Imagen actual:</p>
        <img src="../../public/images/<?= $producto['imagen'] ?>" alt="Imagen del producto" width="100"><br>
    <?php endif; ?>

    <button type="submit"><?= $producto ? 'Actualizar' : 'Crear' ?></button>
</form>

    <a href="index.php">Regresar</a>
</body>
</html>
