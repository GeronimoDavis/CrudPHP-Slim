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

       
        public function showRegisterForm(Request $request, Response $response){
            try{
                ob_start();
                require __DIR__ . '/../../views/registro.php';
                $html = ob_get_clean();

                $response->getBody()->write($html);
                return $response->withHeader('Content-Type', 'text/html')->withStatus(200);
            }catch(Exception $e){
                $errorResponse = ['error' => 'Error al mostrar formulario: ' . $e->getMessage()];
                $response->getBody()->write(json_encode($errorResponse));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500); 
            }
        }

        public function registerUsuario(Request $request, Response $response){
            try{
                $data = $request->getParsedBody();
                
                // Validaciones
                if(empty($data['nombre']) || empty($data['email']) || empty($data['password']) || empty($data['password_confirm'])){
                    $errorResponse = ['error' => 'Todos los campos son requeridos'];
                    $response->getBody()->write(json_encode($errorResponse));
                    return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
                }

                if($data['password'] !== $data['password_confirm']){
                    $errorResponse = ['error' => 'Las contraseñas no coinciden'];
                    $response->getBody()->write(json_encode($errorResponse));
                    return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
                }

                if(!filter_var($data['email'], FILTER_VALIDATE_EMAIL)){
                    $errorResponse = ['error' => 'Email inválido'];
                    $response->getBody()->write(json_encode($errorResponse));
                    return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
                }

                // Hashear contraseña
                $passwordHasheada = password_hash($data['password'], PASSWORD_BCRYPT);

                $usuario = new Usuario(null, $data['nombre'], $data['email'], $passwordHasheada);
                $usuarioCreado = $this->UServices->register($usuario);
        
                // Convertimos el objeto Entidad a array simple para el json_encode (sin mostrar la contraseña)
                $usuarioArray = $usuarioCreado->toArray();
                unset($usuarioArray['password']); // No devolvemos la contraseña
        
                $response->getBody()->write(json_encode(['success' => true, 'message' => 'Usuario registrado exitosamente', 'usuario' => $usuarioArray]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(201); 
            }catch(Exception $e){
                $errorResponse = ['error' => 'Error al registrar usuario: ' . $e->getMessage()];
                $response->getBody()->write(json_encode($errorResponse));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500); 
            }
        }

        

    }
?>