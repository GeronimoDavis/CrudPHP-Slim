<?php
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\ProyectoControllers;


return function ($app) {
    $app->group('/proyectos', function (RouteCollectorProxy $group) {
        $group->get('/show', ProyectoControllers::class . ':getAllProyectos'); 
        $group->get('/show/{id}', ProyectoControllers::class . ':getAllProyectos');
        $group->post('/create', ProyectoControllers::class . ':createProyecto'); 
        $group->post('/update/{id}', ProyectoControllers::class . ':updateProyecto');
        $group->delete('/delete/{id}', ProyectoControllers::class . ':deleteProyecto');   
    });
};