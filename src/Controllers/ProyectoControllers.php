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
                $proyectos = $this->PServices->getAll();

                // 2. Guardamos la vista en el búfer de PHP para Slim
                ob_start();
                require __DIR__ . '/../../views/verProyectos.php';
                $html = ob_get_clean();// guardamos el contenido de la vista en una variable sin mostrar la vista todavía

                $response->getBody()->write($html);
                return $response->withHeader('Content-Type', 'text/html')->withStatus(200);//con 'text/html' le decimos al navegador que lo que le estamos enviando es una vista html y no un json
    
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
                return $response->withHeader('Location', '/proyectos/show')->withStatus(302);

            }catch(Exception $e){
                $errorResponse = ['error' => 'Error al crear el proyectos: ' . $e->getMessage()];
                $response->getBody()->write(json_encode($errorResponse));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
            }
        
        }   

        public function updateProyecto(Request $request, Response $response, $args): Response{
            try{
                $id = $args['id'];
                $datos = $request->getParsedBody();
                if(!isset($datos['nombre']) || empty(trim($datos['nombre']))){
                    throw new Exception("El nombre del proyecto es obligatorio.");
                }
                $proyecto = new Proyecto($id, $datos['nombre'], $datos['descripcion'] ?? "", 1);

                $this->PServices->update($proyecto);
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);

            }catch(Exception $e){
                $errorResponse = ['error' => 'Error al actualizar el proyectos: ' . $e->getMessage()];
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