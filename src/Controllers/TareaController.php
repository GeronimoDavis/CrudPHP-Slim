<?php 
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\TareaServices;
use App\Entities\Tarea;

class TareaController{

    private $TServices;

    public function __construct()
    {
        $this->TServices = new TareaServices();
    }

    public function getAllbyIdProyecto(Request $request, Response $response, array $args = []){
        try{
            $proyectoId = $args['proyecto_id'] ?? null;
            if(!$proyectoId){
                $errorResponse = ['error' => 'ID de proyecto no proporcionado'];
                $response->getBody()->write(json_encode($errorResponse));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }

            $tareas = $this->TServices->getAllbyId($proyectoId);
            $tareasArray = array_map(function($tarea) {
                return $tarea->toArray();
            }, $tareas);

            $response->getBody()->write(json_encode($tareasArray));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        }catch(\Exception $e){
            $errorResponse = ['error' => 'Error al obtener tareas: ' . $e->getMessage()];
            $response->getBody()->write(json_encode($errorResponse));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500); 
        }
    }
}


?>