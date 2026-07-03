<?php 
    namespace App\Controllers;

    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;
    use App\Services\UsuarioServices;
    use App\Entities\Usuario;
    use Exception;

    class UsuarioControllers{

        private $UServices;

        public function __construct()
        {
            $this->UServices = new UsuarioServices();
        }

        public function getAllUsuarios(Request $request, Response $response){
            try{
                $usuariosEntities = $this->UServices->getAll();
        
                // Convertimos el array de Objetos Entidad a arrays simples para el json_encode
                $usuariosArray = array_map(fn($u) => $u->toArray(), $usuariosEntities);

                $response->getBody()->write(json_encode($usuariosArray));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
    
            }catch(Exception $e){
                $errorResponse = ['error' => 'Error al obtener los usuarios: ' . $e->getMessage()];
                $response->getBody()->write(json_encode($errorResponse));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500); 
            }
        }

    }
?>