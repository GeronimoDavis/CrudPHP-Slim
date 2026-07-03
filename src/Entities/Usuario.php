<?php
namespace App\Entities;

class Usuario{
    private ?int $id;
    private string $nombre;
    private string $email;
    private string $password;

    public function __construct(?int $id, string $nombre, string $email, string $password) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
    }

    // Getters y Setters
    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): void { $this->id = $id; }

    public function getNombre(): string { return $this->nombre; }
    public function setNombre(string $nombre): void { $this->nombre = $nombre; }

    public function getEmail(): string { return $this->email; }
    public function setEmail(string $email): void { $this->email = $email; }

    public function getPassword(): string { return $this->password; }
    public function setPassword(string $password): void { $this->password = $password; }

    // Método utilitario para convertir la entidad a un array (para cuando respondamos JSON)
    public function toArray(): array {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'email' => $this->email,
            'password' => $this->password
        ];
    }
}