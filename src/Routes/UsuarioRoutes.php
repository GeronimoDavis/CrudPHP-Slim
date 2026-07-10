<?php
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\UsuarioControllers;


return function ($app) {
    $app->group('/usuarios', function (RouteCollectorProxy $group) {
        $group->get('/showForm', UsuarioControllers::class . ':showForm');
        $group->get('/showForm/{action}', UsuarioControllers::class . ':showForm');
        $group->get('/logout', UsuarioControllers::class . ':logoutUsuario');
        $group->post('/register', UsuarioControllers::class . ':registerUsuario'); 
        $group->post('/login', UsuarioControllers::class . ':loginUsuario');
    });
};