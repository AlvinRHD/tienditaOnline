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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrito de Compras</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- Contenedor principal -->
    <div class="max-w-7xl mx-auto py-8 px-4 flex-grow">

        <!-- Título -->
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Carrito de Compras</h1>
        <a href="../home/index.php" class="inline-block text-white bg-gray-500 hover:bg-gray-600 py-2 px-4 rounded-lg shadow-md mb-6 ml-4">Regresar al Inicio</a>

        <?php if ($rol === 'cliente'): ?>
            <!-- Vista para clientes -->
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tu Carrito</h2>
            
            <!-- Tabla del carrito -->
            <table class="min-w-full bg-white border border-gray-200 shadow-lg rounded-lg mb-6 w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Producto</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Precio</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Cantidad</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Total</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Imagen</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($productosEnCarrito)): ?>
                        <?php foreach ($productosEnCarrito as $producto): ?>
                            <tr class="border-b">
                                <td class="py-4 px-6"><?= htmlspecialchars($producto['nombre']) ?></td>
                                <td class="py-4 px-6">$<?= number_format($producto['precio'], 2) ?></td>
                                <td class="py-4 px-6">
                                    <form action="../../controllers/CarritoController.php" method="POST" class="flex items-center">
                                        <input type="hidden" name="carrito_id" value="<?= $producto['carrito_id'] ?>">
                                        <input type="number" name="cantidad" value="<?= $producto['cantidad'] ?>" min="1" required class="w-16 px-2 py-1 border rounded-md text-center">
                                        <button type="submit" name="update_quantity" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Actualizar</button>
                                    </form>
                                </td>
                                <td class="py-4 px-6">$<?= number_format($producto['precio'] * $producto['cantidad'], 2) ?></td>
                                <td class="py-4 px-6">
                                    <img src="../../public/image/<?= htmlspecialchars($producto['imagen']) ?>" alt="Imagen del producto" class="w-20 h-20 object-cover rounded-md">
                                </td>
                                <td class="py-4 px-6">
                                    <a href="../../controllers/CarritoController.php?action=remove&carrito_id=<?= $producto['carrito_id'] ?>" class="text-red-600 hover:text-red-700" onclick="return confirm('¿Estás seguro de eliminar este producto del carrito?')">Eliminar</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="py-4 px-6 text-center text-gray-500">El carrito está vacío.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>


            <!-- Botón para confirmar compra -->
            <form action="../../controllers/VentasController.php" method="POST" class="text-center">
                <button type="submit" name="confirmar_venta" class="bg-red-600 text-white font-bold py-2 px-4 rounded hover:bg-red-700">Confirmar Compra</button>
            </form>
        <?php endif; ?>


        <?php if ($rol === 'admin'): ?>
            <!-- Vista para administradores -->
            <h2 class="text-2xl font-semibold text-gray-800 mb-4">Carritos de Todos los Clientes</h2>
           

            <!-- Tabla de carritos de clientes -->
            <table class="min-w-full bg-white border border-gray-200 shadow-lg rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">ID Cliente</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Nombre Cliente</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Producto</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Cantidad</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Precio</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($carritos)): ?>
                        <?php foreach ($carritos as $carrito): ?>
                            <tr class="border-b">
                                <td class="py-4 px-6"><?= $carrito['usuario_id'] ?></td>
                                <td class="py-4 px-6"><?= htmlspecialchars($carrito['nombre_cliente']) ?></td>
                                <td class="py-4 px-6"><?= htmlspecialchars($carrito['nombre_producto']) ?></td>
                                <td class="py-4 px-6"><?= $carrito['cantidad'] ?></td>
                                <td class="py-4 px-6">$<?= number_format($carrito['precio'], 2) ?></td>
                                <td class="py-4 px-6">$<?= number_format($carrito['total'], 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="py-4 px-6 text-center text-gray-500">No hay productos en los carritos.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        <?php endif; ?>

    </div>

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
