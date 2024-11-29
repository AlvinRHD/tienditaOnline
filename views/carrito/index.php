<?php
session_start();
require_once '../../config/db.php';
require_once '../../models/Carrito.php';
require_once '../../models/Producto.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$carritoModel = new Carrito($pdo);
$productosModel = new Productos($pdo);
$usuario_id = $_SESSION['usuario_id']; // Usuario logueado
$productosEnCarrito = $carritoModel->getByUserId($usuario_id);
$productosDisponibles = $productosModel->getAll(); // Obtener productos disponibles
?>

<!DOCTYPE html>
<html>
<head>
    <title>Carrito de Compras</title>
</head>
<body>
    <h1>Carrito de Compras</h1>

    <!-- Mostrar mensajes de error o éxito -->
    <?php if (isset($_GET['error']) && $_GET['error'] == 'empty'): ?>
        <p style="color: red;">El carrito está vacío. Agrega productos antes de confirmar la compra.</p>
    <?php endif; ?>

    <?php if (isset($_GET['success']) && $_GET['success'] == 'completed'): ?>
        <p style="color: green;">¡Compra confirmada exitosamente!</p>
    <?php endif; ?>

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
            <?php if (!empty($productosEnCarrito)): ?>
                <?php foreach ($productosEnCarrito as $producto): ?>
                    <tr>
                        <td><?= htmlspecialchars($producto['nombre']) ?></td>
                        <td>$<?= number_format($producto['precio'], 2) ?></td>
                        <td>
                            <form action="../../controllers/CarritoController.php" method="POST">
                                <input type="hidden" name="carrito_id" value="<?= $producto['carrito_id'] ?>">
                                <input type="number" name="cantidad" value="<?= $producto['cantidad'] ?>" min="1" required>
                                <button type="submit" name="update_quantity">Actualizar</button>
                            </form>
                        </td>
                        <td>$<?= number_format($producto['precio'] * $producto['cantidad'], 2) ?></td>
                        <td>
                            <img src="../../public/image/<?= htmlspecialchars($producto['imagen']) ?>" alt="Imagen del producto" width="50">
                        </td>
                        <td>
                            <a href="../../controllers/CarritoController.php?action=remove&carrito_id=<?= $producto['carrito_id'] ?>" onclick="return confirm('¿Estás seguro de eliminar este producto del carrito?')">Eliminar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6">El carrito está vacío.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Formulario para añadir productos al carrito -->
    <h2>Añadir Producto al Carrito</h2>
    <form action="../../controllers/CarritoController.php" method="POST">
        <input type="hidden" name="usuario_id" value="<?= $usuario_id ?>">
        <label for="producto_id">Producto:</label>
        <select name="producto_id" id="producto_id" required>
            <?php foreach ($productosDisponibles as $producto): ?>
                <option value="<?= $producto['producto_id'] ?>">
                    <?= htmlspecialchars($producto['nombre']) ?> ($<?= number_format($producto['precio'], 2) ?>)
                </option>
            <?php endforeach; ?>
        </select><br>

        <label for="cantidad">Cantidad:</label>
        <input type="number" name="cantidad" value="1" min="1" required><br>

        <button type="submit" name="add_to_cart">Añadir al carrito</button>
    </form>

    <!-- Botón para confirmar compra -->
    <form action="../../controllers/VentasController.php" method="POST">
        <button type="submit" name="confirmar_venta">Confirmar Compra</button>
    </form>

    <a href="../home/index.php">Regresar</a>
</body>
</html>
