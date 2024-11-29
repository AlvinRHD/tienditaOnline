<?php
session_start();

// Verificar si el usuario está logueado y es un cliente
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'cliente') {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../../config/db.php';
require_once '../../models/Producto.php';
require_once '../../models/Carrito.php';
require_once '../../models/Categoria.php'; // Incluir el modelo de categorías

// Instanciar los modelos
$productoModel = new Productos($pdo);
$carritoModel = new Carrito($pdo);
$categoriaModel = new Categoria($pdo);

// Obtener todas las categorías
$categorias = $categoriaModel->getAll();

// Buscar productos por término
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';
if ($searchTerm) {
    $productos = $productoModel->search($searchTerm);
} else {
    // Filtrar productos por categoría seleccionada
    $categoria_id = isset($_GET['categoria']) ? $_GET['categoria'] : '';
    if ($categoria_id) {
        $productos = $productoModel->getByCategory($categoria_id);
    } else {
        $productos = $productoModel->getAll(); // Obtener todos los productos
    }
}

// Obtener el ID del usuario logueado
$usuario_id = $_SESSION['usuario_id']; 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home - Tienda Online</title>
</head>
<body>
    <h1>Bienvenido a la Tienda Online</h1>

    <!-- Barra de búsqueda -->
    <form action="index.php" method="GET">
        <input type="text" name="search" placeholder="Buscar productos..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
        <button type="submit">Buscar</button>
    </form>

    <!-- Filtro por categoría -->
    <form action="index.php" method="GET">
        <select name="categoria">
            <option value="">Todas las categorías</option>
            <?php foreach ($categorias as $categoria): ?>
                <option value="<?= $categoria['categoria_id'] ?>" <?= isset($_GET['categoria']) && $_GET['categoria'] == $categoria['categoria_id'] ? 'selected' : '' ?>>
                    <?= $categoria['nombre_categoria'] ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Filtrar</button>
    </form>

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
