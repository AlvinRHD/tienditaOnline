<?php
require_once '../config/db.php';
require_once '../models/Carrito.php';

$carritoModel = new Carrito($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Manejar agregar al carrito
    if (isset($_POST['add_to_cart'])) {
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

    // Manejar actualización de cantidad en el carrito
    if (isset($_POST['update_quantity'])) {
        $carrito_id = $_POST['carrito_id'];
        $cantidad = $_POST['cantidad'];

        // Verificar si la cantidad solicitada es válida
        if ($cantidad > 0) {
            $carritoModel->updateQuantity($carrito_id, $cantidad);
        } else {
            // Mostrar mensaje de cantidad inválida
            echo "<script>alert('La cantidad debe ser mayor que 0.');</script>";
        }
        header("Location: ../views/carrito/index.php");
        exit;
    }

    // Eliminar producto del carrito
    if (isset($_GET['action']) && $_GET['action'] === 'remove' && isset($_GET['carrito_id'])) {
        $carrito_id = $_GET['carrito_id'];
        $carritoModel->removeFromCart($carrito_id);
        header("Location: ../views/carrito/index.php");
        exit;
    }
}
?>
