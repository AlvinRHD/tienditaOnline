<?php
if (!isset($_GET['venta_id'])) {
    header("Location: ../home/index.php");
    exit;
}
$venta_id = $_GET['venta_id'];
echo "¡Gracias por tu compra! Tu venta ID es: " . $venta_id;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra Confirmada</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="container mx-auto p-6 text-center">
        <h1 class="text-3xl font-bold text-gray-700 mb-4">¡Compra Confirmada!</h1>
        <p class="text-lg text-gray-600 mb-6">Gracias por tu compra. El ID de tu venta es: <strong><?= $venta_id ?></strong></p>

        <div>
            <a href="../home/index.php" class="inline-block text-white bg-blue-500 hover:bg-blue-600 py-2 px-4 rounded-lg shadow-md mb-4">Volver al Inicio</a>
            <a href="index.php" class="inline-block text-white bg-gray-500 hover:bg-gray-600 py-2 px-4 rounded-lg shadow-md">Regresar a ventas</a>
        </div>
    
    </div>
    

</body>
</html>
