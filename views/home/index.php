<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit;
}



// Si el usuario es cliente, continuar mostrando el home.

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
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <!-- Navbar -->
    <header class="bg-red-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="#" class="text-2xl font-semibold">Tienda Online</a>
            <nav>
                <ul class="flex space-x-4">
                    <?php if ($_SESSION['rol'] === 'admin'): ?>
                        <li><a href="../productos/index.php" class="hover:text-gray-300">Productos</a></li>
                        <li><a href="../categorias/index.php" class="hover:text-gray-300">Categorías</a></li>
                        <li><a href="../usuarios/index.php" class="hover:text-gray-300">Usuarios</a></li>
                        <li><a href="../pedidos/index.php" class="hover:text-gray-300">Pedidos</a></li>
                        <li><a href="../ventas/index.php" class="hover:text-gray-300">Ventas</a></li>
                    <?php endif; ?>
                    <li><a href="../carrito/index.php" class="hover:text-gray-300">Carrito</a></li>
                    <li><a href="../../views/auth/logout.php" class="hover:text-gray-300">Cerrar sesión</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <!-- Barra de búsqueda y filtro -->
    <section class="bg-white py-6 shadow-md">
        <div class="container mx-auto flex justify-between items-center">
            <form action="index.php" method="GET" class="flex space-x-4">
                <input type="text" name="search" placeholder="Buscar productos..." value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" class="px-4 py-2 border rounded-lg w-96">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Buscar</button>
            </form>
            <form action="index.php" method="GET" class="flex space-x-4">
                <select name="categoria" class="px-4 py-2 border rounded-lg">
                    <option value="">Todas las categorías</option>
                    <?php foreach ($categorias as $categoria): ?>
                        <option value="<?= $categoria['categoria_id'] ?>" <?= isset($_GET['categoria']) && $_GET['categoria'] == $categoria['categoria_id'] ? 'selected' : '' ?>>
                            <?= $categoria['nombre_categoria'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Filtrar</button>
            </form>
        </div>
    </section>


     


    <!-- Productos -->
    <section class="py-6">
        <div class="container mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            <?php foreach ($productos as $producto): ?>
                <div class="bg-white p-4 rounded-lg shadow-lg">
                    <img src="../../public/image/<?= $producto['imagen'] ?>" alt="Imagen del producto" class="w-full h-48 object-cover rounded-lg mb-4">
                    <h3 class="text-xl font-semibold"><?= $producto['nombre'] ?></h3>
                    <p class="text-gray-600 text-sm mb-2"><?= $producto['descripcion'] ?></p>
                    <p class="text-lg font-bold text-red-600">Precio: $<?= number_format($producto['precio'], 2) ?></p>
                    <p class="text-sm text-gray-500 mb-4">Cantidad disponible: <?= $producto['cantidad_disponible'] ?></p>

                    <form action="../../controllers/CarritoController.php" method="POST" class="space-y-4">
                        <input type="hidden" name="usuario_id" value="<?= $usuario_id ?>">
                        <input type="hidden" name="producto_id" value="<?= $producto['producto_id'] ?>">

                        <div class="flex items-center space-x-2">
                            <label for="cantidad" class="text-sm">Cantidad:</label>
                            <input type="number" name="cantidad" value="1" min="1" max="<?= $producto['cantidad_disponible'] ?>" required class="px-4 py-2 border rounded-lg w-20">
                        </div>

                        <?php if ($producto['cantidad_disponible'] == 0): ?>
                            <p class="text-red-600 text-sm">Producto agotado</p>
                        <?php else: ?>
                            <button type="submit" name="add_to_cart" class="w-full bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Añadir al carrito</button>
                        <?php endif; ?>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </section>
    

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-auto">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <h4 class="font-semibold text-lg mb-4">Sobre Nosotros</h4>
                    <p class="text-sm text-gray-400">En Tienda Online, ofrecemos los mejores productos a precios competitivos, con un enfoque en la satisfacción del cliente.</p>
                    <hr>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-4">Enlaces Rápidos</h4>
                    <ul>
                        <li><a href="../home/index.php" class="text-sm text-gray-400 hover:text-gray-200">Inicio</a></li>
                        <hr>
                    </ul>
                </div>
                <div>
                    <h4 class="font-semibold text-lg mb-4">Contacto</h4>
                    <p class="text-sm text-gray-400">Correo: contacto@tiendaonline.com</p>
                    <p class="text-sm text-gray-400">Teléfono: 123-456-7890</p>
                    <a href="#" class="text-sm text-gray-400 hover:text-gray-200">Face</a>
                    <a href="#" class="text-sm text-gray-400 hover:text-gray-200">Ig</a>
                    <a href="#" class="text-sm text-gray-400 hover:text-gray-200">twitter</a>
                    <hr>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
