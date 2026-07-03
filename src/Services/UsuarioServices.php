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
    
    public function getAll(): array{
        try{
            $sql = "SELECT * FROM usuarios";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll();

            $usuarios = [];
            foreach($rows as $row){
                $usuarios[] = new Usuario($row['id'], $row['nombre'], $row['email'], $row['password']);
                
            }
           
            return $usuarios;
        }catch(PDOException $e){
            
            throw new Exception("Error al obtener los usuarios: " . $e->getMessage());
            
        }
    }

}