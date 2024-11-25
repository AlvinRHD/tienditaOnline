<?php
require_once '../../config/db.php';
require_once '../../models/Usuario.php';

$usuarioModel = new Usuario($pdo);
$usuarios = $usuarioModel->getAll();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Usuarios</title>
</head>
<body>
    <h1>Usuarios</h1>
    <a href="form.php">Añadir Usuario</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($usuarios as $usuario): ?>
                <tr>
                    <td><?= $usuario['usuario_id'] ?></td>
                    <td><?= $usuario['nombre'] ?></td>
                    <td><?= $usuario['email'] ?></td>
                    <td><?= $usuario['rol'] ?></td>
                   
                    <td>
                    <a href="form.php?id=<?= $usuario['usuario_id'] ?>">Editar</a>
                    <a href="../../controllers/UsuarioController.php?action=delete&id=<?= $usuario['usuario_id'] ?>" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</a>
                    </td>

                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
