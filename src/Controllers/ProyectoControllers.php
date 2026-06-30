<?php 
    namespace App\Controllers;

    use App\Services\ProyectoServices;
    use App\Entities\Proyecto;
    use Exception;

    class ProyectoControllers{

        private $PServices;//hace referencia a la instancia del poyectoServices

        public function __construct()
        {
            $this->PServices = new ProyectoServices();
        }

        public function getAllProyectos($request, $response){
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

}


?>