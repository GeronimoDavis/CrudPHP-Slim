<?php 
    namespace App\Controllers;

    use Psr\Http\Message\ServerRequestInterface as Request;
    use Psr\Http\Message\ResponseInterface as Response;
    use App\Services\UsuarioServices;
    use App\Entities\Usuario;
    use Exception;
    use session_start();

    class UsuarioControllers{

        private $UServices;

        public function __construct()
        {
            $this->UServices = new UsuarioServices();
        }

       
        public function showForm(Request $request, Response $response, array $args = []){
            try{
                $action = $args['action'] ?? ($request->getQueryParams()['action'] ?? null);// Si no se proporciona una acción, será null
                ob_start();
                require __DIR__ . '/../../views/registroLogin.php';
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

        

        public function loginUsuario(Request $request, Response $response){
            try{
                session_start(); // Iniciamos la sesión para poder almacenar información del usuario logueado
                $data = $request->getParsedBody();
                
                if(empty($data['email']) || empty($data['password'])){
                    $errorResponse = ['error' => 'Email y contraseña son requeridos'];
                    $response->getBody()->write(json_encode($errorResponse));
                    return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
                }

                $usuario = $this->UServices->login($data['email'], $data['password']);
                
                // Guardamos la información del usuario en la sesión
                $usuario->toArray(); 
                $id = $usuario->getId();
                $nombre = $usuario->getNombre();

                $_SESSION['usuario'] = [
                    'id' => $id,
                    'nombre' => $nombre
                ];
                     
                // Convertimos el objeto Entidad a array simple para el json_encode (sin mostrar la contraseña)
                $usuarioArray = $usuario->toArray();
                unset($usuarioArray['password']); // No devolvemos la contraseña
        
               
                

                $response->getBody()->write(json_encode(['success' => true, 'message' => 'Login exitoso', 'usuario' => $usuarioArray]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200); 
            }catch(Exception $e){
                $errorResponse = ['error' => 'Error al logearse: ' . $e->getMessage()];
                $response->getBody()->write(json_encode($errorResponse));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(500); 
            }
        }
        

        

    }
?>