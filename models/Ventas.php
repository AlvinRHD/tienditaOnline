<?php

class Ventas {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllVentas() {
        $sql = "SELECT v.venta_id, v.fecha_venta, v.total, v.estado, u.nombre AS nombre_cliente
                FROM Ventas v
                INNER JOIN Usuarios u ON v.usuario_id = u.usuario_id
                ORDER BY v.fecha_venta DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Registrar una nueva venta
    public function registrarVenta($usuario_id, $total) {
        $sql = "INSERT INTO Ventas (usuario_id, total) VALUES (:usuario_id, :total)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['usuario_id' => $usuario_id, 'total' => $total]);
        return $this->pdo->lastInsertId(); // Retorna el ID de la venta recién creada
    }
    

    // Obtener todas las ventas de un usuario
    public function getVentasPorUsuario($usuario_id) {
        $sql = "SELECT * FROM Ventas WHERE usuario_id = :usuario_id ORDER BY fecha_venta DESC";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['usuario_id' => $usuario_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Actualizar estado de una venta
    public function actualizarEstado($venta_id, $estado) {
        $sql = "UPDATE Ventas SET estado = :estado WHERE venta_id = :venta_id";
        $stmt = $this->pdo->prepare($sql);
        return $stmt->execute(['estado' => $estado, 'venta_id' => $venta_id]);
    }
}
