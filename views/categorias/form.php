<?php
require_once '../../config/db.php';
require_once '../../models/Categoria.php';

$categoriaModel = new Categoria($pdo);

// Si estamos editando, cargamos los datos de la categoría
$categoria = null;
if (isset($_GET['id'])) {
    $categoria = $categoriaModel->getById($_GET['id']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $categoria ? 'Editar Categoría' : 'Crear Categoría' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <a href="index.php" class="text-blue-500 hover:text-blue-700 mb-6 inline-block">Regresar a categorías</a>

        <h1 class="text-3xl font-bold text-gray-700 mb-6"><?= $categoria ? 'Editar Categoría' : 'Crear Categoría' ?></h1>

        <form action="../../controllers/CategoriaController.php" method="POST" class="bg-white p-6 shadow-lg rounded-lg max-w-lg mx-auto">
            <input type="hidden" name="action" value="<?= $categoria ? 'update' : 'create' ?>">
            <?php if ($categoria): ?>
                <input type="hidden" name="id" value="<?= $categoria['categoria_id'] ?>">
            <?php endif; ?>

            <div class="mb-4">
                <label for="nombre_categoria" class="block text-gray-700 text-sm font-semibold mb-2">Nombre de la Categoría:</label>
                <input type="text" name="nombre_categoria" id="nombre_categoria" value="<?= $categoria['nombre_categoria'] ?? '' ?>" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-200">
            </div>

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded-lg"> 
                <?= $categoria ? 'Actualizar' : 'Crear' ?>
            </button>
        </form>
    </div>

</body>
</html>
