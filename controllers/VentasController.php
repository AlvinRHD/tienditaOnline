<?php
require_once '../config/db.php';
require_once '../models/Ventas.php';
require_once '../models/Carrito.php';

$ventasModel = new Ventas($pdo);
$carritoModel = new Carrito($pdo);

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
        
        // Vaciar carrito después de confirmar la venta
        $carritoModel->vaciarCarrito($usuario_id);
        
        header("Location: ../views/ventas/confirmacion.php?venta_id=$venta_id");
        exit;
    } else {
        header("Location: ../views/carrito/index.php?error=empty");
        exit;
    }
}
