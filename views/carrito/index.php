<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../../config/db.php';
require_once '../../models/Carrito.php';
require_once '../../models/Producto.php';

$carritoModel = new Carrito($pdo);
$productosModel = new Productos($pdo);
$usuario_id = $_SESSION['usuario_id']; // Usuario logueado
$rol = $_SESSION['rol']; // Rol del usuario (admin o cliente)

// Si el usuario es cliente, obtenemos su carrito y productos disponibles
if ($rol === 'cliente') {
    $productosEnCarrito = $carritoModel->getByUserId($usuario_id);
    $productosDisponibles = $productosModel->getAll();
}

// Si el usuario es admin, obtenemos el carrito de todos los clientes
if ($rol === 'admin') {
    $carritos = $carritoModel->getCarritoPorClientes();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Carrito de Compras</title>
</head>
<body>
    <h1>Carrito de Compras</h1>

    <?php if ($rol === 'cliente'): ?>
        <!-- Vista para clientes -->
        <h2>Tu Carrito</h2>
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

        <form action="../../controllers/VentasController.php" method="POST">
            <button type="submit" name="confirmar_venta">Confirmar Compra</button>
        </form>
    <?php endif; ?>

    <?php if ($rol === 'admin'): ?>
        <!-- Vista para administradores -->
        <h2>Carritos de Todos los Clientes</h2>
        <table>
            <thead>
                <tr>
                    <th>ID Cliente</th>
                    <th>Nombre Cliente</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($carritos)): ?>
                    <?php foreach ($carritos as $carrito): ?>
                        <tr>
                            <td><?= $carrito['usuario_id'] ?></td>
                            <td><?= htmlspecialchars($carrito['nombre_cliente']) ?></td>
                            <td><?= htmlspecialchars($carrito['nombre_producto']) ?></td>
                            <td><?= $carrito['cantidad'] ?></td>
                            <td>$<?= number_format($carrito['precio'], 2) ?></td>
                            <td>$<?= number_format($carrito['total'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No hay productos en los carritos.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <a href="../home/index.php">Regresar</a>
</body>
</html>
