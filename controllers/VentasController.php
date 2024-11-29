<?php
require_once '../config/db.php';
require_once '../models/Ventas.php';
require_once '../models/Carrito.php';
require_once '../models/Pedido.php';

$ventasModel = new Ventas($pdo);
$carritoModel = new Carrito($pdo);
$pedidoModel = new Pedido($pdo);

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirmar_venta'])) {
    session_start();
    
    $usuario_id = $_SESSION['usuario_id']; // ID del usuario logueado
    $productosCarrito = $carritoModel->getProductosCarrito($usuario_id);
    
    if (count($productosCarrito) > 0) {
        $total = array_sum(array_map(function ($item) {
            return $item['precio'] * $item['cantidad'];
        }, $productosCarrito));
        
        // Registrar la venta
        $venta_id = $ventasModel->registrarVenta($usuario_id, $total);
        
        // Registrar los productos de la venta en la tabla Pedidos
        foreach ($productosCarrito as $producto) {
            $subtotal = $producto['precio'] * $producto['cantidad'];
            $pedidoModel->registrarPedido($venta_id, $producto['producto_id'], $producto['cantidad'], $subtotal);
        }
        
        // Vaciar carrito después de confirmar la venta
        $carritoModel->vaciarCarrito($usuario_id);
        
        header("Location: ../views/ventas/confirmacion.php?venta_id=$venta_id");
        exit;
    } else {
        header("Location: ../views/carrito/index.php?error=empty");
        exit;
    }
}
?>
