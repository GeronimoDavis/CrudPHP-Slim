<?php
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\ProyectoController;
use App\Controllers\ProyectoControllers;

return function ($app) {
    $proyectoController = new ProyectoControllers();
    // Agrupamos todas las rutas que empiecen con /proyectos
    $app->group('/proyectos', function (RouteCollectorProxy $group) use ($proyectoController) {
        
        $group->get('/show', [$proyectoController, 'getAllProyectos']); // Ruta para obtener todos los proyectos   
    });

};