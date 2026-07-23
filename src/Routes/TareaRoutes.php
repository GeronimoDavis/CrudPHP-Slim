<?php
use Slim\Routing\RouteCollectorProxy;
use App\Controllers\TareaController;


return function ($app) {
    $app->group('/tareas', function (RouteCollectorProxy $group) {
        $group->get('/show[/{proyecto_id}]', TareaController::class . ':getAllbyIdProyecto');
        $group->post('/create', TareaController::class . ':createTarea');
        $group->post('/delete/{proyecto_id}/{tarea_id}', TareaController::class . ':deleteTarea');
        $group->delete('/delete/{proyecto_id}/{tarea_id}', TareaController::class . ':deleteTarea');
        $group->post('/update/{tarea_id}', TareaController::class . ':updateTarea');
    });
};