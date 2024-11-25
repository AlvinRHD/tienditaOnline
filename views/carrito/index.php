<?php
require_once '../../config/db.php';
require_once '../../models/Carrito.php';

$carritoModel = new Carrito($pdo);
$usuario_id = 1; // Cambiar por el ID real del usuario logueado
$productosEnCarrito = $carritoModel->getByUserId($usuario_id);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Carrito de Compras</title>
</head>
<body>
    <h1>Carrito de Compras</h1>
    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Imagen</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($productosEnCarrito as $producto): ?>
                <tr>
                    <td><?= $producto['nombre'] ?></td>
                    <td><?= $producto['precio'] ?></td>
                    <td>
                        <form action="../../controllers/CarritoController.php" method="POST">
                            <input type="hidden" name="carrito_id" value="<?= $producto['carrito_id'] ?>">
                            <input type="number" name="cantidad" value="<?= $producto['cantidad'] ?>" min="1" required>
                            <button type="submit" name="update_quantity">Actualizar</button>
                        </form>
                    </td>
                    <td><?= $producto['precio'] * $producto['cantidad'] ?></td>
                    <td><img src="../../public/image/<?= $producto['imagen'] ?>" alt="Imagen del producto" width="50"></td>
                    <td>
                        <a href="../../controllers/CarritoController.php?action=remove&carrito_id=<?= $producto['carrito_id'] ?>" onclick="return confirm('¿Estás seguro de eliminar este producto del carrito?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <form action="../../controllers/CarritoController.php" method="POST">
        <input type="hidden" name="usuario_id" value="<?= $usuario_id ?>">
        <label for="producto_id">Producto:</label>
        <select name="producto_id" id="producto_id" required>
            <!-- Aquí deberías cargar los productos disponibles desde la base de datos -->
            <option value="1">Producto 1</option>
            <option value="2">Producto 2</option>
        </select><br>

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" value="1" min="1" required><br>

        <button type="submit" name="add_to_cart">Añadir al carrito</button>
    </form>
    
    <a href="../home/index.php">Regresar</a>
</body>
</html>
