<?php
namespace App\Entities;

class Proyecto {
    private ?int $id;
    private string $nombre;
    private ?string $descripcion;
    private ?int $usuario_id;

    public function __construct(?int $id, string $nombre = "", ?string $descripcion = null, ?int $usuario_id = null) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->usuario_id = $usuario_id;
    }

    // Getters y Setters
    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }

    public function getNombre(): string { return $this->nombre; }
    public function setNombre(string $nombre): void { $this->nombre = $nombre; }

    public function getDescripcion(): ?string { return $this->descripcion; }
    public function setDescripcion(?string $descripcion): void { $this->descripcion = $descripcion; }

    public function getUsuarioId(): ?int { return $this->usuario_id; }
    public function setUsuarioId(?int $usuario_id): void { $this->usuario_id = $usuario_id; }

    // Método utilitario para convertir la entidad a un array (para cuando respondamos JSON)
    public function toArray(): array {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'usuario_id' => $this->usuario_id
        ];
    }
}