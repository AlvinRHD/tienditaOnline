<?php
session_start();

// Verificar si el usuario está logueado y es un cliente
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] != 'cliente') {
    header("Location: ../auth/login.php");
    exit;
}

require_once '../../config/db.php';
require_once '../../models/Ventas.php';

$ventasModel = new Ventas($pdo);
$usuario_id = $_SESSION['usuario_id'];
$ventas = $ventasModel->getVentasPorUsuario($usuario_id);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Mis Compras</title>
</head>
<body>
    <h1>Mis Compras</h1>
    <a href="../home/index.php">Volver al Inicio</a>

    <?php if (count($ventas) > 0): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ventas as $venta): ?>
                    <tr>
                        <td><?= $venta['venta_id'] ?></td>
                        <td><?= $venta['fecha_venta'] ?></td>
                        <td>$<?= number_format($venta['total'], 2) ?></td>
                        <td><?= ucfirst($venta['estado']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No has realizado compras aún.</p>
    <?php endif; ?>
</body>
</html>
