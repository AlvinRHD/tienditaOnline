<?php
require_once '../config/db.php';
require_once '../models/Pedido.php';

$pedidoModel = new Pedido($pdo);

session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id']; // ID del usuario logueado

// Obtener los pedidos del usuario
$pedidos = $pedidoModel->getPedidosByUsuarioId($usuario_id);

// Pasar los pedidos a la vista
require_once '../views/pedidos/index.php';
?>
