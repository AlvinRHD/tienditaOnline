<?php
if (!isset($_GET['venta_id'])) {
    header("Location: ../home/index.php");
    exit;
}
$venta_id = $_GET['venta_id'];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Compra Confirmada</title>
</head>
<body>
    <h1>¡Compra Confirmada!</h1>
    <p>Gracias por tu compra. El ID de tu venta es: <strong><?= $venta_id ?></strong></p>
    <a href="../home/index.php">Volver al inicio</a>
</body>
</html>
