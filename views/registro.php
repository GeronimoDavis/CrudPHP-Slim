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
    <h2>Registrar Usuario</h2>

    <form action="/usuarios/register" method="POST">
        <input type="text" name="nombre" placeholder="Nombre completo" required>
        <input type="email" name="email" placeholder="Correo electrónico" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <input type="password" name="password_confirm" placeholder="Confirmar contraseña" required>
        
        <input type="hidden" name="action" value="register">
        <button type="submit">Registrarse</button>
    </form>

    <p>¿Ya tienes cuenta? <a href="/login">Inicia sesión aquí</a></p>

</body>
</html>
