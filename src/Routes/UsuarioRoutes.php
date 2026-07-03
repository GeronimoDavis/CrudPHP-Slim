<?php
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UsuarioControllers;


return function ($app) {
    $app->group('/usuarios', function (RouteCollectorProxy $group) {
        $group->get('/show', UsuarioControllers::class . ':getAllUsuarios'); 
    });
};