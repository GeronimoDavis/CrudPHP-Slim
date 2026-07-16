<?php
use Slim\Factory\AppFactory;
// Importamos la clase del middleware de sobreescritura de métodos
use Slim\Middleware\MethodOverrideMiddleware;
require __DIR__ . '/../vendor/autoload.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$app = AppFactory::create();

$app->addBodyParsingMiddleware();// Middleware para parsear el cuerpo de las solicitudes (por ejemplo, JSON)
$app->add(new MethodOverrideMiddleware()); // Middleware para permitir métodos HTTP como PUT y DELETE a través de formularios HTML
$app->addRoutingMiddleware();// analiza la ruta de la solicitud y la asigna al controlador correspondiente mirando mis rutas definidas en src/Routes/ProyectoRoutes.php
$app->addErrorMiddleware(true, true, true);// Middleware para manejar errores y excepciones de manera más amigable (true, true, true) muestra detalles de los errores en la respuesta

// Requerimos e invocamos el archivo de rutas pasándole la variable a $app
$registerProyectoRoutes = require __DIR__ . '/../src/Routes/ProyectoRoutes.php';
$registerProyectoRoutes($app);

$registerUsuarioRoutes = require __DIR__ . '/../src/Routes/UsuarioRoutes.php';
$registerUsuarioRoutes($app);

$registerTareaRoutes = require __DIR__ . '/../src/Routes/TareaRoutes.php';
$registerTareaRoutes($app);

$app->run();