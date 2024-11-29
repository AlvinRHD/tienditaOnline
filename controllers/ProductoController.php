<?php
require_once '../config/db.php';
require_once '../models/Producto.php';

$productoModel = new Productos($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    // Procesar la imagen
    $imagen = $_FILES['imagen']['name'] ?? '';
    if ($imagen) {
        $targetDir = "../public/image/";
        $targetFile = $targetDir . basename($imagen);

        // Subir la imagen al servidor
        if (!move_uploaded_file($_FILES['imagen']['tmp_name'], $targetFile)) {
            die("Error al subir la imagen.");
        }
    } else {
        // Si no se carga una nueva imagen, mantener la existente al editar
        $imagen = $_POST['imagen_existente'] ?? '';
    }

    if ($action === 'create') {
        $productoModel->create(
            $_POST['nombre'],
            $_POST['descripcion'],
            $_POST['precio'],
            $_POST['cantidad_disponible'],
            $_POST['categoria_id'],
            $imagen
        );
    } elseif ($action === 'update') {
        $productoModel->update(
            $_POST['id'],
            $_POST['nombre'],
            $_POST['descripcion'],
            $_POST['precio'],
            $_POST['cantidad_disponible'],
            $_POST['categoria_id'],
            $imagen
        );
    }
    header("Location: ../views/productos/index.php");
    exit;
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
    $productoModel->delete($_GET['id']);
    header("Location: ../views/productos/index.php");
    exit;
}
?>
