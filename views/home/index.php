<?php
require_once '../../config/db.php';
require_once '../../models/Producto.php';
require_once '../../models/Carrito.php';

$productoModel = new Productos($pdo);
$carritoModel = new Carrito($pdo);
$productos = $productoModel->getAll();

$usuario_id = 1; // Cambiar por el ID real del usuario logueado (normalmente lo obtienes de la sesión)
?>
<!DOCTYPE html>
<html>
<head>
    <title>Home - Tienda Online</title>
</head>
<body>
    <h1>Bienvenido a la Tienda Online</h1>

    <h2>Productos Disponibles</h2>
    <div class="productos">
        <?php foreach ($productos as $producto): ?>
            <div class="producto">
                <img src="../../public/image/<?= $producto['imagen'] ?>" alt="Imagen del producto" width="150">
                <h3><?= $producto['nombre'] ?></h3>
                <p><?= $producto['descripcion'] ?></p>
                <p>Precio: $<?= number_format($producto['precio'], 2) ?></p>
                <p>Cantidad disponible: <?= $producto['cantidad_disponible'] ?></p>
                
                <form action="../../controllers/CarritoController.php" method="POST">
                    <input type="hidden" name="usuario_id" value="<?= $usuario_id ?>">
                    <input type="hidden" name="producto_id" value="<?= $producto['producto_id'] ?>">
                    <label for="cantidad">Cantidad:</label>
                    <input type="number" name="cantidad" value="1" min="1" max="<?= $producto['cantidad_disponible'] ?>" required>
                    
                    <?php if ($producto['cantidad_disponible'] == 0): ?>
                        <p>Producto agotado</p>
                    <?php else: ?>
                        <button type="submit" name="add_to_cart">Añadir al carrito</button>
                    <?php endif; ?>
                </form>

                <?php
                    // Verificar si la cantidad solicitada excede la cantidad disponible
                    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_to_cart'])) {
                        $cantidad_solicitada = $_POST['cantidad'];
                        if ($cantidad_solicitada > $producto['cantidad_disponible']) {
                            echo "<p>Solo quedan {$producto['cantidad_disponible']} unidades disponibles. Si desea más, contáctenos directamente.</p>";
                        }
                    }
                ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
