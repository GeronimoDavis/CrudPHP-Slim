<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Proyectos - Monolítico</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; padding: 20px; }
        form { background: #f4f4f4; padding: 20px; margin-bottom: 20px; border-radius: 5px; }
        input, textarea, button { display: block; width: 100%; margin-bottom: 10px; padding: 8px; box-sizing: border-box; }
        .card { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; border-radius: 4px; }
    </style>
</head>
<body>
    <?php $id = $id ?? null; ?>

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
        <?php foreach ($proyectos as $proy): ?>
            <div class="card">
                <h3><?php echo htmlspecialchars($proy->getNombre()); ?></h3>
                <p><?php echo htmlspecialchars($proy->getDescripcion() ?? 'Sin descripción'); ?></p>
                <form action="/proyectos/delete/<?php echo $proy->getId(); ?>" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este proyecto?');">
                    <input type="hidden" name="_METHOD" value="DELETE"> <!-- Esto es para simular un DELETE request; Slim busca el campo `_METHOD` en mayúsculas -->
                    <button type="submit">Eliminar</button>
                </form>
                <a href="/proyectos/show/<?php echo $proy->getId(); ?>" >
                    <button>Actualizar</button>
                </a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>