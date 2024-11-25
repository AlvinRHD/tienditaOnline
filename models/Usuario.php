<?php
class Usuario {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAll() {
        $stmt = $this->pdo->query("SELECT * FROM Usuarios");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM Usuarios WHERE usuario_id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nombre, $email, $direccion, $telefono, $password, $rol) {
        $stmt = $this->pdo->prepare("INSERT INTO Usuarios (nombre, email, direccion, telefono, password, rol) VALUES (?, ?, ?, ?, ?, ?)");
        return $stmt->execute([$nombre, $email, $direccion, $telefono, password_hash($password, PASSWORD_BCRYPT), $rol]);
    }

    public function update($id, $nombre, $email, $direccion, $telefono, $rol) {
        $stmt = $this->pdo->prepare("UPDATE Usuarios SET nombre = ?, email = ?, direccion = ?, telefono = ?, rol = ? WHERE usuario_id = ?");
        return $stmt->execute([$nombre, $email, $direccion, $telefono, $rol, $id]);
    }

    public function delete($id) {
        $stmt = $this->pdo->prepare("DELETE FROM Usuarios WHERE usuario_id = ?");
        return $stmt->execute([$id]);
    }
}
?>
