<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

$app = AppFactory::create();

$app->addBodyParsingMiddleware();// Middleware para parsear el cuerpo de las solicitudes (por ejemplo, JSON)
$app->addRoutingMiddleware();// analiza la ruta de la solicitud y la asigna al controlador correspondiente mirando mis rutas definidas en src/Routes/ProyectoRoutes.php
$app->addErrorMiddleware(true, true, true);// Middleware para manejar errores y excepciones de manera más amigable (true, true, true) muestra detalles de los errores en la respuesta

// Requerimos e invocamos el archivo de rutas pasándole la variable a $app
$registerProyectoRoutes = require __DIR__ . '/../src/Routes/proyectoRoutes.php';
$registerProyectoRoutes($app);

$app->run();