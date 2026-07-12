<?php
namespace App\Entities;

class Tarea{
    private ?int $id;
    private string $descripcion;
    private string $estado;
    private ?int $proyecto_id;

    public function __construct(?int $id, string $descripcion, string $estado, ?int $proyecto_id) {
        $this->id = $id;
        $this->descripcion = $descripcion;
        $this->estado = $estado;
        $this->proyecto_id = $proyecto_id;
    }

    // Getters y Setters
    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }

    public function getDescripcion(): string { return $this->descripcion; }
    public function setDescripcion(string $descripcion): void { $this->descripcion = $descripcion; }

    public function getEstado(): string { return $this->estado; }
    public function setEstado(string $estado): void { $this->estado = $estado; }

    public function getProyectoId(): ?int { return $this->proyecto_id; }
    public function setProyectoId(?int $proyecto_id): void { $this->proyecto_id = $proyecto_id; }

    

    // Método utilitario para convertir la entidad a un array (para cuando respondamos JSON)
    public function toArray(): array {
        return [
            'id' => $this->id,
            'descripcion' => $this->descripcion,
            'estado' => $this->estado,
            'proyecto_id' => $this->proyecto_id
        ];
    }
}