<?php
class Categoria {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM Categorias");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Categorias WHERE categoria_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nombre_categoria) {
        $stmt = $this->pdo->prepare("INSERT INTO Categorias (nombre_categoria) VALUES (?)");
        return $stmt->execute([$nombre_categoria]);
    }

    public function update($id, $nombre_categoria) {
        $stmt = $this->pdo->prepare("UPDATE Categorias SET nombre_categoria = ? WHERE categoria_id = ?");
        return $stmt->execute([$nombre_categoria, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Categorias WHERE categoria_id = ?");
        return $stmt->execute([$id]);
    }
}
?>
