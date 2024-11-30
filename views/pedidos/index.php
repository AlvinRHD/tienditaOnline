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
<html>
<head>
    <title>Pedidos de Clientes</title>
</head>
<body>
    <h1>Bienvenido, Administrador</h1>
    <h2>Pedidos de Clientes</h2>
    <a href="../home/index.php">Regresar al Inicio</a>

    <?php if (!empty($pedidos)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID Cliente</th>
                    <th>Nombre Cliente</th>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Subtotal</th>
                    <th>Fecha de Venta</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pedidos as $pedido): ?>
                    <tr>
                        <td><?= $pedido['usuario_id'] ?></td>
                        <td><?= htmlspecialchars($pedido['nombre_cliente']) ?></td>
                        <td><?= htmlspecialchars($pedido['nombre_producto']) ?></td>
                        <td><?= $pedido['cantidad'] ?></td>
                        <td>$<?= number_format($pedido['subtotal'], 2) ?></td>
                        <td><?= $pedido['fecha_venta'] ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay pedidos registrados.</p>
    <?php endif; ?>
</body>
</html>
