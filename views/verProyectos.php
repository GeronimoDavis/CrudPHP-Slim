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

    <h2>Crear Nuevo Proyecto</h2>
    <form action="/proyectos/create" method="POST">
        <input type="text" name="nombre" placeholder="Nombre del proyecto" required>
        <textarea name="descripcion" placeholder="Descripción"></textarea>
        <button type="submit">Guardar Proyecto</button>
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
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

</body>
</html>