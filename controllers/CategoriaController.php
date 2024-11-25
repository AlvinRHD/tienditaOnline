<?php
require_once '../config/db.php';
require_once '../models/Categoria.php';

$categoriaModel = new Categoria($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'create') {
        $categoriaModel->create($_POST['nombre_categoria']);
    } elseif ($action === 'update') {
        $categoriaModel->update($_POST['id'], $_POST['nombre_categoria']);
    }
    header("Location: ../views/categorias/index.php");
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $categoriaModel->delete($_GET['id']);
    header("Location: ../views/categorias/index.php");
    exit;
}
?>
