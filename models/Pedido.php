<?php
class Pedido {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getPedidosPorClientes() {
        $sql = "SELECT p.pedido_id, u.usuario_id, u.nombre AS nombre_cliente, pr.nombre AS nombre_producto, 
                       p.cantidad, p.subtotal, v.fecha_venta
                FROM Pedidos p
                INNER JOIN Ventas v ON p.venta_id = v.venta_id
                INNER JOIN Usuarios u ON v.usuario_id = u.usuario_id
                INNER JOIN Productos pr ON p.producto_id = pr.producto_id
                ORDER BY u.usuario_id, v.fecha_venta";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Registrar un pedido
    public function registrarPedido($venta_id, $producto_id, $cantidad, $subtotal) {
        $stmt = $this->pdo->prepare("INSERT INTO Pedidos (venta_id, producto_id, cantidad, subtotal) VALUES (:venta_id, :producto_id, :cantidad, :subtotal)");
        $stmt->bindParam(':venta_id', $venta_id);
        $stmt->bindParam(':producto_id', $producto_id);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':subtotal', $subtotal);
        $stmt->execute();
    }

    // Obtener los pedidos de un usuario
    public function getPedidosByUsuarioId($usuario_id) {
        $stmt = $this->pdo->prepare("SELECT p.pedido_id, v.fecha_venta, pr.nombre, p.cantidad, p.subtotal 
                                     FROM Pedidos p
                                     JOIN Ventas v ON p.venta_id = v.venta_id
                                     JOIN Productos pr ON p.producto_id = pr.producto_id
                                     WHERE v.usuario_id = :usuario_id");
        $stmt->bindParam(':usuario_id', $usuario_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
