<?php
namespace App\Services;

use App\Entities\Proyecto;
use App\Config\DB;
use PDO;
use PDOException;
use Exception;

class ProyectoServices {

    private $conn;

    public function __construct(){
        $db = new DB();
        $this->conn = $db->connect();
    }

    function getAll(): array{
        try{
            $sql = "SELECT * FROM proyectos";
            $stmt = $this->conn->prepare($sql);
        
            $proyectos = [];
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                $proyectos = new Proyecto($row['id'], $row['nombre'], $row['descripcion'], $row['usuario_id']);
                
            }
            return $proyectos;
        }catch(PDOException $e){
            return [];
            throw new Exception("Error al obtener los proyectos: " . $e->getMessage());
        }
    }
    


}
?>
