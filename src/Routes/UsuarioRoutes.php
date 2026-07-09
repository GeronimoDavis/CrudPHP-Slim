<?php
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UsuarioControllers;


return function ($app) {
    $app->group('/usuarios', function (RouteCollectorProxy $group) {
        $group->get('/register', UsuarioControllers::class . ':showRegisterForm');
        $group->post('/register', UsuarioControllers::class . ':registerUsuario'); 
    });
};