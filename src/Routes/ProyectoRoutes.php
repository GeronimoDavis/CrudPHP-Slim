<?php
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\ProyectoController;

return function ($app) {
    $proyectoController = new ProyectoController();
    // Agrupamos todas las rutas que empiecen con /proyectos
    $app->group('/proyectos', function (RouteCollectorProxy $group) use ($proyectoController) {
        
        $group->get('/show', [$proyectoController, 'getAllProyectos']); // Ruta para obtener todos los proyectos   
    });

};