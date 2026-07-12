<?php

namespace App\Services;
    
use App\Entities\Tarea;
use App\Config\DB;
use PDO;
use PDOException;
use Exception;

class TareaServices {

    private $conn;

    public function __construct(){
        
        $db = new DB();
        $this->conn = $db->connect();
    }

    public function getAllbyId($proyectoId): array{
        try{
            $sql = "SELECT * FROM tareas WHERE proyecto_id = :proyecto_id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":proyecto_id", $proyectoId);
            $stmt->execute();
            $rows = $stmt->fetchAll();

            $tareas = [];
            foreach($rows as $row){
                $tareas[] = new Tarea($row['id'], $row['descripcion'], $row['estado'], $row['proyecto_id']);
                
            }
           
            return $tareas;
        }catch(PDOException $e){
            
            throw new Exception("Error al obtener las tareas: " . $e->getMessage());
            
        }
    }
}