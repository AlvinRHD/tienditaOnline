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

// Incluir los archivos necesarios
require_once '../../config/db.php'; // Asegúrate de que este archivo configura correctamente tu conexión a la base de datos
require_once '../../models/Pedido.php'; // Incluir el modelo de pedidos

// Crear una instancia del modelo de pedidos
$pedidosModel = new Pedido($pdo); // $pdo debe estar configurado en db.php

// Obtener pedidos de todos los clientes
$pedidos = $pedidosModel->getPedidosPorClientes();

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pedidos de Clientes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Pedidos de Clientes</h1>
        <a href="../home/index.php" class="inline-block text-white bg-gray-500 hover:bg-gray-600 py-2 px-4 rounded-lg shadow-md mb-6">Regresar al Inicio</a>

        <?php if (!empty($pedidos)): ?>
            <table class="min-w-full bg-white border border-gray-200 shadow-lg rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">ID Cliente</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Nombre Cliente</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Producto</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Cantidad</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Subtotal</th>
                        <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Fecha de Venta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pedidos as $pedido): ?>
                        <tr class="border-b">
                            <td class="py-4 px-6"><?= $pedido['usuario_id'] ?></td>
                            <td class="py-4 px-6"><?= htmlspecialchars($pedido['nombre_cliente']) ?></td>
                            <td class="py-4 px-6"><?= htmlspecialchars($pedido['nombre_producto']) ?></td>
                            <td class="py-4 px-6"><?= $pedido['cantidad'] ?></td>
                            <td class="py-4 px-6">$<?= number_format($pedido['subtotal'], 2) ?></td>
                            <td class="py-4 px-6"><?= $pedido['fecha_venta'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-lg text-gray-600 mt-4">No hay pedidos registrados.</p>
        <?php endif; ?>
    </div>

</body>
</html>

