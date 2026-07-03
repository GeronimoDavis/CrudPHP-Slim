<?php 
    namespace App\Controllers;

    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;
    use App\Services\ProyectoServices;
    use App\Entities\Proyecto;
    use Exception;

    class ProyectoControllers{

        private $PServices;//hace referencia a la instancia del poyectoServices

        public function __construct()
        {
            $this->PServices = new ProyectoServices();
        }

        public function getAllProyectos(Request $request, Response $response){
            try{
                $proyectosEntities = $this->PServices->getAll();
        
                // Convertimos el array de Objetos Entidad a arrays simples para el json_encode
                $proyectosArray = array_map(fn($p) => $p->toArray(), $proyectosEntities);

                $response->getBody()->write(json_encode($proyectosArray));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200); // 200 OK
    
            }catch(Exception $e){
                $errorResponse = ['error' => 'Error al obtener los proyectos: ' . $e->getMessage()];
                $response->getBody()->write(json_encode($errorResponse));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500); // 500 Internal Server Error
            }
        }

        public function createProyecto(Request $request, Response $response): Response{
            try{
                $datos = $request->getParsedBody();   
                $proyecto = new Proyecto(null, $datos['nombre'] ?? '', $datos['descripcion'] ?? null, 1);

                $createdProduct = $this->PServices->create($proyecto);
                    
                $response->getBody()->write(json_encode(['product' => $createdProduct->toArray()]));
                return $response->withHeader('Content-type', 'application/json')->withStatus(201);

            }catch(Exception $e){
                $errorResponse = ['error' => 'Error al crear el proyectos: ' . $e->getMessage()];
                $response->getBody()->write(json_encode($errorResponse));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
            }
        
        }   

        public function deleteProyecto(Request $request, Response $response, $args): Response{
            try{
                $id = $args['id'];
                $this->PServices->delete($id);
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);

            }catch(Exception $e){
                $errorResponse = ['error' => 'Error al borrar el proyectos: ' . $e->getMessage()];
                $response->getBody()->write(json_encode($errorResponse));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
            }
        }
}


?>