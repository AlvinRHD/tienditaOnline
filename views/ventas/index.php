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

// El contenido para los administradores
echo "<h1>Bienvenido, Administrador</h1>";

require_once '../../config/db.php';
require_once '../../models/Ventas.php';

$ventasModel = new Ventas($pdo);
$usuario_id = $_SESSION['usuario_id'];
$ventas = $ventasModel->getVentasPorUsuario($usuario_id);
// Obtener todas las ventas
$ventas = $ventasModel->getAllVentas();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Ventas de Clientes</title>
</head>
<body>
    <h1>Ventas de Clientes</h1>
    <a href="../home/index.php">Regresar al Inicio</a>

    <?php if (!empty($ventas)): ?>
        <table border="1">
            <thead>
                <tr>
                    <th>ID Venta</th>
                    <th>Cliente</th>
                    <th>Fecha</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($ventas as $venta): ?>
                    <tr>
                        <td><?= $venta['venta_id'] ?></td>
                        <td><?= htmlspecialchars($venta['nombre_cliente']) ?></td>
                        <td><?= $venta['fecha_venta'] ?></td>
                        <td>$<?= number_format($venta['total'], 2) ?></td>
                        <td><?= ucfirst($venta['estado']) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p>No hay ventas registradas.</p>
    <?php endif; ?>
</body>
</html>
