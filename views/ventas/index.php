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
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ventas de Clientes</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-gray-700 mb-6">Ventas de Clientes</h1>
        
        <a href="../home/index.php" class="inline-block text-white bg-gray-500 hover:bg-gray-600 py-2 px-4 rounded-lg shadow-md mb-6">Regresar al Inicio</a>

        <?php if (!empty($ventas)): ?>
            <table class="min-w-full table-auto bg-white border border-gray-300 rounded-lg shadow-md">
                <thead>
                    <tr class="bg-gray-200 text-gray-700">
                        <th class="py-2 px-4 border-b">ID Venta</th>
                        <th class="py-2 px-4 border-b">Cliente</th>
                        <th class="py-2 px-4 border-b">Fecha</th>
                        <th class="py-2 px-4 border-b">Total</th>
                        <th class="py-2 px-4 border-b">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ventas as $venta): ?>
                        <tr class="hover:bg-gray-100">
                            <td class="py-2 px-4 border-b"><?= $venta['venta_id'] ?></td>
                            <td class="py-2 px-4 border-b"><?= htmlspecialchars($venta['nombre_cliente']) ?></td>
                            <td class="py-2 px-4 border-b"><?= $venta['fecha_venta'] ?></td>
                            <td class="py-2 px-4 border-b">$<?= number_format($venta['total'], 2) ?></td>
                            <td class="py-2 px-4 border-b"><?= ucfirst($venta['estado']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-gray-700">No hay ventas registradas.</p>
        <?php endif; ?>
    </div>
</body>
</html>