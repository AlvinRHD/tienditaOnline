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
<html>
<head>
    <title>Productos</title>
</head>
<body>
    <h1>Productos</h1>
    <a href="form.php">Añadir Producto</a>
    <a href="../home/index.php">Regresar al Inicio</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Categoría</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productos as $producto): ?>
                <tr>
                    <td><?= $producto['producto_id'] ?></td>
                    <td><?= $producto['nombre'] ?></td>
                    <td><?= $producto['descripcion'] ?></td>
                    <td><?= $producto['precio'] ?></td>
                    <td><?= $producto['cantidad_disponible'] ?></td>
                    <td><?= $producto['nombre_categoria'] ?? 'Sin categoría' ?></td>
                    <td><img src="../../public/image/<?= $producto['imagen'] ?>" alt="Imagen del producto" width="50"></td>
                    <td>
                        <a href="form.php?id=<?= $producto['producto_id'] ?>">Editar</a>
                        <a href="../../controllers/ProductoController.php?action=delete&id=<?= $producto['producto_id'] ?>" onclick="return confirm('¿Estás seguro de eliminar este producto?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
