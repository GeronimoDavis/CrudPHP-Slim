<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de Usuario</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 40px auto; padding: 20px; }
        form { background: #f4f4f4; padding: 20px; margin-bottom: 20px; border-radius: 5px; }
        input, textarea, button { display: block; width: 100%; margin-bottom: 10px; padding: 8px; box-sizing: border-box; }
        .card { border: 1px solid #ccc; padding: 10px; margin-bottom: 10px; border-radius: 4px; }
        a { text-decoration: none; }
        a button { margin-top: 5px; }
    </style>
</head>
<body>

    <?php $action = $action ?? null; ?>

    <?php if (!empty($action) && $action === 'login'): ?>
        <h2>Iniciar Sesión</h2>
    <?php else: ?>
        <h2>Crear Cuenta</h2>
    <?php endif; ?>
    
    
    <form action="<?php echo !empty($action) && $action === 'login' ? '/usuarios/login' : '/usuarios/register'; ?>" method="POST">
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        
        <?php if (empty($action) || $action !== 'login'): ?>
            <input type="text" name="nombre" placeholder="Nombre completo" required>
            <input type="password" name="password_confirm" placeholder="Confirmar contraseña" required>
        <?php endif; ?>
        
        <input type="hidden" name="action" value="<?php echo !empty($action) && $action === 'login' ? 'login' : 'register'; ?>">
        <button type="submit"><?php echo !empty($action) && $action === 'login' ? 'Iniciar Sesión' : 'Registrarse'; ?></button>
    </form>


    <?php if (!empty($action) && $action === 'login'): ?>
        <a href="/usuarios/showForm?action=register" >
            <button>Crear Cuenta</button>
        </a>
    <?php else: ?>
        <a href="/usuarios/showForm?action=login" >
            <button>Iniciar Sesión</button>
        </a>
    <?php endif; ?>
    
    
   
</body>
</html>
