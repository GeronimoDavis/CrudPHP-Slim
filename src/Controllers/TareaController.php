<?php 
namespace App\Controllers;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use App\Services\TareaServices;
use App\Services\ProyectoServices;
use App\Entities\Tarea;
use Exception;

class TareaController{

    private $TServices;
    private $PServices;

    public function __construct()
    {
        $this->TServices = new TareaServices();
        $this->PServices = new ProyectoServices();
    }

    public function getAllbyIdProyecto(Request $request, Response $response, array $args = []){
        try{
            $proyectoId = $args['proyecto_id'] ?? null;
            if(!$proyectoId){
                return $response->withHeader('Location', '/proyectos/show')->withStatus(302);
            }

            $tareas = $this->TServices->getAllbyId($proyectoId);
            $proyecto = $this->PServices->getById($proyectoId);

            ob_start();
            require __DIR__ . '/../../views/verTareas.php';
            $html = ob_get_clean();

            $response->getBody()->write($html);
            return $response->withHeader('Content-Type', 'text/html')->withStatus(200);
        }catch(Exception $e){
            $errorResponse = ['error' => 'Error al obtener tareas: ' . $e->getMessage()];
            $response->getBody()->write(json_encode($errorResponse));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500); 
        }
    }

    public function createTarea(Request $request, Response $response, array $args = []){
        try{
            $data = $request->getParsedBody();

            $descripcion = $data['descripcion'] ?? null;
            $estado = $data['estado'] ?? null;
            $proyectoId = $data['proyecto_id'] ?? null;

            if(!$descripcion || !$estado || !$proyectoId){
                throw new Exception("Faltan datos para crear la tarea.");
            }

            $tarea = new Tarea(null, $descripcion, $estado, $proyectoId);
            $this->TServices->create($tarea);

            return $response->withHeader('Location', '/tareas/show/' . urlencode($proyectoId))->withStatus(302);
        }catch(Exception $e){
            $errorResponse = ['error' => 'Error al crear la tarea: ' . $e->getMessage()];
            $response->getBody()->write(json_encode($errorResponse));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500); 
        }
    }

    public function deleteTarea(Request $request, Response $response, array $args = []){
        try{
            $proyectoId = $args['proyecto_id'] ?? null;
            $tareaId = $args['tarea_id'] ?? null;

            if(!$proyectoId || !$tareaId){
                throw new Exception("Faltan datos para eliminar la tarea.");
            }

            $this->TServices->delete($tareaId);

            return $response->withHeader('Location', '/tareas/show/' . urlencode($proyectoId))->withStatus(302);
        }catch(Exception $e){
            $errorResponse = ['error' => 'Error al eliminar la tarea: ' . $e->getMessage()];
            $response->getBody()->write(json_encode($errorResponse));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500); 
        }
    }

    public function updateTarea(Request $request, Response $response, array $args = []){
        try{
            $data = $request->getParsedBody();
            $tareaId = $args['tarea_id'] ?? null;
            $proyectoId = $data['proyecto_id'] ?? null;

            if(!$tareaId || !$proyectoId){
                throw new Exception("Faltan datos para actualizar la tarea.");
            }

            $descripcion = $data['descripcion'] ?? null;
            $estado = $data['estado'] ?? null;

            if(!$descripcion || !$estado){
                throw new Exception("Faltan campos para actualizar la tarea.");
            }

            $tarea = new Tarea($tareaId, $descripcion, $estado, $proyectoId);
            $this->TServices->update($tarea);

            return $response->withHeader('Location', '/tareas/show/' . urlencode($proyectoId))->withStatus(302);
        }catch(Exception $e){
            $errorResponse = ['error' => 'Error al actualizar la tarea: ' . $e->getMessage()];
            $response->getBody()->write(json_encode($errorResponse));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500); 
        }
    }

    
}


?>