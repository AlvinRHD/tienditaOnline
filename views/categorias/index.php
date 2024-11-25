<?php
require_once '../../config/db.php';
require_once '../../models/Categoria.php';

$categoriaModel = new Categoria($pdo);
$categorias = $categoriaModel->getAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Categorías</title>
</head>
<body>
    <h1>Categorías</h1>
    <a href="form.php">Añadir Categoría</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?= $categoria['categoria_id'] ?></td>
                    <td><?= $categoria['nombre_categoria'] ?></td>
                    <td>
                        <a href="form.php?id=<?= $categoria['categoria_id'] ?>">Editar</a>
                        <a href="../../controllers/CategoriaController.php?action=delete&id=<?= $categoria['categoria_id'] ?>" onclick="return confirm('¿Estás seguro de eliminar esta categoría?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="../usuarios/index.php">Volver al inicio</a>
</body>
</html>
