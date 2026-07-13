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

    public function create(Tarea $tarea){
        try{
            $sql = "INSERT INTO tareas (descripcion, estado, proyecto_id) VALUES (:descripcion, :estado, :proyecto_id)";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":descripcion", $tarea->getDescripcion());
            $stmt->bindParam(":estado", $tarea->getEstado());
            $stmt->bindParam(":proyecto_id", $tarea->getProyectoId());
            $stmt->execute();

            $id = $this->conn->lastInsertId();
            $tarea->setId($id);

        }catch(PDOException $e){
            throw new Exception("Error al crear la tarea: " . $e->getMessage());
        }
    }

    public function delete($tareaId){
        try{
            $sql = "DELETE FROM tareas WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $tareaId);
            $stmt->execute();

        }catch(PDOException $e){
            throw new Exception("Error al eliminar la tarea: " . $e->getMessage());
        }
    }
}