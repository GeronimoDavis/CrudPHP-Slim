<?php
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    $usuarioId = $_SESSION['usuario']['id'] ?? null;
    if(empty($usuarioId)){
        header("Location: /usuarios/showForm/login");
        exit;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Proyectos - Monolítico</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 760px; margin: 24px auto; padding: 18px; }
        form { background: #f4f4f4; padding: 18px; margin-bottom: 20px; border-radius: 8px; }
        input, textarea { display: block; width: 100%; margin-bottom: 10px; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        button { border: none; border-radius: 4px; background: #007bff; color: #fff; cursor: pointer; padding: 10px 14px; font-size: 0.95rem; }
        button[type="button"] { background: #6c757d; }
        button:hover { opacity: 0.95; }
        .project-table-wrapper { max-height: 360px; overflow-y: auto; border: 1px solid #ccc; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 10px 12px; text-align: left; border-bottom: 1px solid #ddd; font-size: 0.95rem; }
        th { background: #f8f9fa; position: sticky; top: 0; z-index: 1; }
        td.actions { white-space: nowrap; }
        td.actions form, td.actions a { display: inline-block; margin-right: 6px; }
        td.actions button { padding: 6px 10px; font-size: 0.88rem; }
        .description-cell { color: #555; }
    </style>
</head>
<body>
    <?php $id = $id ?? null; ?>

    <div style="display:flex; justify-content: flex-end; margin-bottom: 16px;">
        <a href="/usuarios/logout" style="text-decoration:none;">
            <button type="button" style="background:#dc3545;">Cerrar sesión</button>
        </a>
    </div>

    <?php if (!empty($id)): ?>
        <h2>Actualizar Proyecto</h2>
    <?php else: ?>
        <h2>Crear Proyecto</h2>
    <?php endif; ?>

    <form action="<?php echo !empty($id) ? '/proyectos/update/' . urlencode($id) : '/proyectos/create'; ?>" method="POST">
        <?php if (!empty($proyecto)): ?>
            <input type="text" name="nombre" placeholder="Nombre del proyecto" value="<?php echo htmlspecialchars($proyecto->getNombre()); ?>" required>
            <textarea name="descripcion" placeholder="Descripción"><?php echo htmlspecialchars($proyecto->getDescripcion() ?? ''); ?></textarea>
        <?php else: ?>
            <input type="text" name="nombre" placeholder="Nombre del proyecto" required>
            <textarea name="descripcion" placeholder="Descripción"></textarea>
            <input type="hidden" name="usuario_id" value="<?php echo htmlspecialchars($_SESSION['usuario']['id'], ENT_QUOTES, 'UTF-8'); ?>">
        <?php endif; ?>

        <?php if (!empty($id)): ?>
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($id, ENT_QUOTES, 'UTF-8'); ?>">
            <input type="hidden" name="action" value="update">
            <button type="submit">Actualizar Proyecto</button>
            <a href="/proyectos/show"><button type="button">Cancelar</button></a>
        <?php else: ?>
            <input type="hidden" name="action" value="create">
            <button type="submit">Guardar Proyecto</button>
        <?php endif; ?>
    </form>
    
    

    <h2>Mis Proyectos</h2>
    
    <?php if (empty($proyectos)): ?>
        <p>No hay proyectos aún.</p>
    <?php else: ?>
        <div class="project-table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripción</th>
                        <th style="width: 170px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($proyectos as $proy): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($proy->getNombre()); ?></td>
                            <td class="description-cell"><?php echo htmlspecialchars($proy->getDescripcion() ?? 'Sin descripción'); ?></td>
                            <td class="actions">
                                <form action="/proyectos/delete/<?php echo $proy->getId(); ?>" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este proyecto?');">
                                    <input type="hidden" name="_METHOD" value="DELETE"> <!-- Esto es para simular un DELETE request; Slim busca el campo `_METHOD` en mayúsculas -->
                                    <button type="submit">Eliminar</button>
                                </form>
                                <a href="/proyectos/show/<?php echo $proy->getId(); ?>">
                                    <button type="button">Actualizar</button>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

</body>
</html>