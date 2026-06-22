<?php
namespace App\Config;

use PDO;
use PDOException;

class DB {
    private $host = 'localhost';
    private $user = 'root'; 
    private $pass = '';
    private $dbname = 'practica_slim';

    public function connect() {
        try {
            $conexion = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->user, $this->pass);
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ); 
            return $conexion;
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
}