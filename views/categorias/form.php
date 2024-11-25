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
<html>
<head>
    <title><?= $categoria ? 'Editar Categoría' : 'Crear Categoría' ?></title>
</head>
<body>
    <h1><?= $categoria ? 'Editar Categoría' : 'Crear Categoría' ?></h1>
    <form action="../../controllers/CategoriaController.php" method="POST">
        <input type="hidden" name="action" value="<?= $categoria ? 'update' : 'create' ?>">
        <?php if ($categoria): ?>
            <input type="hidden" name="id" value="<?= $categoria['categoria_id'] ?>">
        <?php endif; ?>
        <label>Nombre de la Categoría:</label>
        <input type="text" name="nombre_categoria" value="<?= $categoria['nombre_categoria'] ?? '' ?>" required><br>
        <button type="submit"><?= $categoria ? 'Actualizar' : 'Crear' ?></button>
    </form>
    <a href="index.php">Regresar</a>
</body>
</html>
