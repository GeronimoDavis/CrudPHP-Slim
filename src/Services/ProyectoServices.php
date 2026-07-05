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

    public function getAll(): array{
        try{
            $sql = "SELECT * FROM proyectos";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $proyectos = [];
            foreach($rows as $row){
                $proyectos[] = new Proyecto($row['id'], $row['nombre'], $row['descripcion'], $row['usuario_id']);
                
            }
           
            return $proyectos;
        }catch(PDOException $e){
            
            throw new Exception("Error al obtener los proyectos: " . $e->getMessage());
            
        }
    }

    public function create(Proyecto $proyecto){
        try{
            $sql = "INSERT INTO proyectos(nombre, descripcion, usuario_id) VALUES (:nombre, :descripcion, :usuario_id)";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(":nombre", $proyecto->getNombre());
        $stmt->bindValue(":descripcion", $proyecto->getDescripcion());
        $stmt->bindValue(":usuario_id", $proyecto->getUsuarioId());
        $stmt->execute();

        // Seteamos el ID directamente en el objeto recibido
        $id = (int)$this->conn->lastInsertId();
        $proyecto->setId($id);

        
        return $proyecto;

        }catch(PDOException $e){
            throw new Exception("Error al crear el proyectos: " . $e->getMessage());
        }
    }

    public function update($id, Proyecto $proyecto){
        try{
            
            $sql = "UPDATE proyectos SET nombre = :nombre, descripcion = :descripcion WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":nombre", $proyecto->getNombre());
            $stmt->bindValue(":descripcion", $proyecto->getDescripcion());
            $stmt->bindValue(":usuario_id", $proyecto->getUsuarioId());
            // Aquí deberías bindear los demás parámetros según lo que quieras actualizar
            $stmt->execute();
        }catch(PDOException $e){
            throw new Exception("Error al actualizar el proyectos: " . $e->getMessage());
        }
    }
    

    public function delete($id){
        try{
            $sql = "DELETE FROM proyectos WHERE id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();

        }catch(PDOException $e){
            
            throw new Exception("Error al borrar el proyectos: " . $e->getMessage());
        }
    }


}
?>
