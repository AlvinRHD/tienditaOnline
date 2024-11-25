<?php
require_once '../config/db.php';
require_once '../models/Usuario.php';

$usuarioModel = new Usuario($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'create') {
        $usuarioModel->create(
            $_POST['nombre'],
            $_POST['email'],
            $_POST['direccion'],
            $_POST['telefono'],
            $_POST['password'],
            $_POST['rol']
        );
    } elseif ($action === 'update') {
        $usuarioModel->update(
            $_POST['id'],
            $_POST['nombre'],
            $_POST['email'],
            $_POST['direccion'],
            $_POST['telefono'],
            $_POST['rol']
        );
    }
    header("Location: ../views/usuarios/index.php");
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $usuarioModel->delete($_GET['id']);
    header("Location: ../views/usuarios/index.php");
    exit;
}
?>
