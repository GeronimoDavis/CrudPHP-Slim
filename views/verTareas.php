<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$usuarioId = $_SESSION['usuario']['id'] ?? null;
if (empty($usuarioId)) {
    header("Location: /usuarios/showForm/login");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tareas del Proyecto</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 760px; margin: 24px auto; padding: 18px; }
        .top-bar { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .top-bar a { text-decoration: none; }
        .card { background: #f8f9fa; padding: 16px; border-radius: 8px; margin-bottom: 18px; border: 1px solid #e0e0e0; }
        form { background: #f4f4f4; padding: 16px; margin-bottom: 18px; border-radius: 8px; }
        input, select { display: block; width: 100%; margin-bottom: 10px; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .task-table-wrapper { border: 1px solid #ddd; border-radius: 8px; overflow: hidden; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f1f3f5; }
        .status { display: inline-block; padding: 4px 8px; border-radius: 999px; font-size: 0.8rem; font-weight: bold; }
        .pendiente { background: #fff3cd; color: #856404; }
        .completada { background: #d4edda; color: #155724; }
        .empty { color: #777; padding: 16px; }
        button { border: none; border-radius: 4px; background: #007bff; color: #fff; cursor: pointer; padding: 8px 12px; }
        button:hover { opacity: 0.95; }
    </style>
</head>
<body>
    <div class="top-bar">
        <h2 style="margin: 0;">Tareas del proyecto</h2>
        <a href="/proyectos/show">
            <button type="button">Volver a proyectos</button>
        </a>
    </div>

    <div class="card">
        <?php if (!empty($proyecto)): ?>
            <h3 style="margin: 0 0 8px;"><?php echo htmlspecialchars($proyecto->getNombre()); ?></h3>
            <p style="margin: 0; color: #555;">
                <?php echo htmlspecialchars($proyecto->getDescripcion() ?? 'Sin descripción'); ?>
            </p>
        <?php else: ?>
            <h3 style="margin: 0;">Proyecto no encontrado</h3>
        <?php endif; ?>
    </div>

    <h3>Crear tarea</h3>
    <form action="/tareas/create" method="POST">
        <input type="text" name="descripcion" placeholder="Descripción de la tarea" required>
        <select name="estado">
            <option value="pendiente">Pendiente</option>
            <option value="completada">Completada</option>
        </select>
        <?php if (!empty($proyecto)): ?>
            <input type="hidden" name="proyecto_id" value="<?php echo htmlspecialchars($proyecto->getId(), ENT_QUOTES, 'UTF-8'); ?>">
        <?php endif; ?>
        <button type="submit">Guardar tarea</button>
    </form>

    <?php if (empty($tareas)): ?>
        <div class="card empty">No hay tareas registradas para este proyecto todavía.</div>
    <?php else: ?>
        <div class="task-table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Descripción</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tareas as $tarea): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($tarea->getDescripcion()); ?></td>
                            <td>
                                <span class="status <?php echo htmlspecialchars($tarea->getEstado()); ?>">
                                    <?php echo htmlspecialchars(ucfirst($tarea->getEstado())); ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</body>
</html>
