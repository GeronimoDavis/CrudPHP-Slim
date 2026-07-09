<?php
namespace App\Services;

use App\Entities\Usuario;
use App\Config\DB;
use PDOException;
use Exception;

class UsuarioServices {

    private $conn;

    public function __construct(){
        $db = new DB();
        $this->conn = $db->connect();
    }
    

    public function register(Usuario $usuario){
        try{
            // Verificar que el email sea único
            $sqlCheck = "SELECT COUNT(*) as count FROM usuarios WHERE email = :email";
            $stmtCheck = $this->conn->prepare($sqlCheck);
            $stmtCheck->bindValue(":email", $usuario->getEmail());
            $stmtCheck->execute();
            $result = $stmtCheck->fetch(\PDO::FETCH_ASSOC);
            
            if($result['count'] > 0){
                throw new Exception("El email ya está registrado");
            }

            $sql = "INSERT INTO usuarios(nombre, email, password) VALUES (:nombre, :email, :password)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":nombre", $usuario->getNombre());
            $stmt->bindValue(":email", $usuario->getEmail());
            $stmt->bindValue(":password", $usuario->getPassword());
            $stmt->execute();

            $id = (int)$this->conn->lastInsertId();
            $usuario->setId($id);

            return $usuario;

        }catch(PDOException $e){
            throw new Exception("Error al registrar usuario: " . $e->getMessage());
        }
    }

}