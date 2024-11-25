<?php
require_once '../config/db.php';
require_once '../models/Carrito.php';

$carritoModel = new Carrito($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_to_cart'])) {
    $producto_id = $_POST['producto_id'];
    $usuario_id = $_POST['usuario_id'];
    $cantidad = $_POST['cantidad'];

    // Verificar si la cantidad solicitada excede la cantidad disponible
    $stmt = $pdo->prepare("SELECT cantidad_disponible FROM Productos WHERE producto_id = ?");
    $stmt->execute([$producto_id]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($producto['cantidad_disponible'] >= $cantidad) {
        $carritoModel->addToCart($usuario_id, $producto_id, $cantidad);
    } else {
        // Mostrar mensaje de cantidad excedida
        echo "<script>alert('La cantidad solicitada excede la cantidad disponible. Solo quedan {$producto['cantidad_disponible']} unidades.');</script>";
    }

    header("Location: ../views/home/index.php");
    exit;
}
?>
