<?php
class Carrito {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getCarritoPorClientes() {
        $sql = "SELECT c.carrito_id, c.usuario_id, u.nombre AS nombre_cliente, p.nombre AS nombre_producto, 
                       c.cantidad, p.precio, (c.cantidad * p.precio) AS total
                FROM Carrito c
                INNER JOIN Usuarios u ON c.usuario_id = u.usuario_id
                INNER JOIN Productos p ON c.producto_id = p.producto_id
                ORDER BY c.usuario_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUserId($usuario_id) {
        $stmt = $this->pdo->prepare("
            SELECT c.carrito_id, p.nombre, p.precio, c.cantidad, p.imagen
            FROM Carrito c
            JOIN Productos p ON c.producto_id = p.producto_id
            WHERE c.usuario_id = ?
        ");
        $stmt->execute([$usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addToCart($usuario_id, $producto_id, $cantidad) {
        $stmt = $this->pdo->prepare("
            INSERT INTO Carrito (usuario_id, producto_id, cantidad) 
            VALUES (?, ?, ?)
        ");
        return $stmt->execute([$usuario_id, $producto_id, $cantidad]);
    }

    public function updateQuantity($carrito_id, $cantidad) {
        $stmt = $this->pdo->prepare("
            UPDATE Carrito SET cantidad = ? WHERE carrito_id = ?
        ");
        return $stmt->execute([$cantidad, $carrito_id]);
    }

    public function removeFromCart($carrito_id) {
        $stmt = $this->pdo->prepare("DELETE FROM Carrito WHERE carrito_id = ?");
        return $stmt->execute([$carrito_id]);
    }

    public function clearCart($usuario_id) {
        $stmt = $this->pdo->prepare("DELETE FROM Carrito WHERE usuario_id = ?");
        return $stmt->execute([$usuario_id]);
    }

        // Obtener los productos del carrito por usuario
        public function getProductosCarrito($usuario_id) {
            $sql = "SELECT c.carrito_id, c.cantidad, p.producto_id, p.nombre, p.precio, p.cantidad_disponible, p.imagen 
                    FROM Carrito c
                    INNER JOIN Productos p ON c.producto_id = p.producto_id
                    WHERE c.usuario_id = :usuario_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['usuario_id' => $usuario_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        
    
        // Vaciar carrito
        public function vaciarCarrito($usuario_id) {
            $sql = "DELETE FROM Carrito WHERE usuario_id = :usuario_id";
            $stmt = $this->pdo->prepare($sql);
            return $stmt->execute(['usuario_id' => $usuario_id]);
        }
}
?>
