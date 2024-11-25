<?php
class Productos {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("
            SELECT p.producto_id, p.nombre, p.descripcion, p.precio, p.cantidad_disponible, p.imagen, c.nombre_categoria 
            FROM Productos p 
            LEFT JOIN Categorias c ON p.categoria_id = c.categoria_id
        ");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Productos WHERE producto_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nombre, $descripcion, $precio, $cantidad, $categoria_id, $imagen) {
        $stmt = $this->pdo->prepare("
            INSERT INTO Productos (nombre, descripcion, precio, cantidad_disponible, categoria_id, imagen) 
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$nombre, $descripcion, $precio, $cantidad, $categoria_id, $imagen]);
    }

    public function update($id, $nombre, $descripcion, $precio, $cantidad, $categoria_id, $imagen) {
        $stmt = $this->pdo->prepare("
            UPDATE Productos 
            SET nombre = ?, descripcion = ?, precio = ?, cantidad_disponible = ?, categoria_id = ?, imagen = ? 
            WHERE producto_id = ?
        ");
        return $stmt->execute([$nombre, $descripcion, $precio, $cantidad, $categoria_id, $imagen, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Productos WHERE producto_id = ?");
        return $stmt->execute([$id]);
    }
}
?>
