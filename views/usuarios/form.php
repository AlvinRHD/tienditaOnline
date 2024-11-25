<?php
require_once '../../config/db.php';
require_once '../../models/Usuario.php';

$usuarioModel = new Usuario($pdo);

// Si se está editando, cargamos los datos del usuario
$usuario = null;
if (isset($_GET['id'])) {
    $usuario = $usuarioModel->getById($_GET['id']);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title><?= $usuario ? 'Editar Usuario' : 'Crear Usuario' ?></title>
</head>
<body>
    <h1><?= $usuario ? 'Editar Usuario' : 'Crear Usuario' ?></h1>
    <form action="../../controllers/UsuarioController.php" method="POST">
        <input type="hidden" name="action" value="<?= $usuario ? 'update' : 'create' ?>">
        <?php if ($usuario): ?>
            <input type="hidden" name="id" value="<?= $usuario['usuario_id'] ?>">
        <?php endif; ?>
        <label>Nombre:</label>
        <input type="text" name="nombre" value="<?= $usuario['nombre'] ?? '' ?>" required><br>

        <label>Email:</label>
        <input type="email" name="email" value="<?= $usuario['email'] ?? '' ?>" required><br>

        <label>Dirección:</label>
        <input type="text" name="direccion" value="<?= $usuario['direccion'] ?? '' ?>"><br>

        <label>Teléfono:</label>
        <input type="text" name="telefono" value="<?= $usuario['telefono'] ?? '' ?>"><br>

        <label>Contraseña:</label>
        <input type="password" name="password" <?= $usuario ? '' : 'required' ?>><br>

        <label>Rol:</label>
        <select name="rol" required>
            <option value="cliente" <?= ($usuario['rol'] ?? '') === 'cliente' ? 'selected' : '' ?>>Cliente</option>
            <option value="admin" <?= ($usuario['rol'] ?? '') === 'admin' ? 'selected' : '' ?>>Administrador</option>
        </select><br>

        <button type="submit"><?= $usuario ? 'Actualizar' : 'Crear' ?></button>
    </form>
    <a href="index.php">Regresar</a>
</body>
</html>
