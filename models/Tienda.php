<?php
declare(strict_types=1);

class Tienda
{
    private ?int $id = null;
    private string $nombre;
    private string $direccion;
    private string $telefono;
    private string $correo;

    public function __construct(
        string $nombre = '',
        string $direccion = '',
        string $telefono = '',
        string $correo = ''
    ) {
        $this->nombre = $nombre;
        $this->direccion = $direccion;
        $this->telefono = $telefono;
        $this->correo = $correo;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function getDireccion(): string
    {
        return $this->direccion;
    }

    public function setDireccion(string $direccion): void
    {
        $this->direccion = $direccion;
    }

    public function getTelefono(): string
    {
        return $this->telefono;
    }

    public function setTelefono(string $telefono): void
    {
        $this->telefono = $telefono;
    }

    public function getCorreo(): string
    {
        return $this->correo;
    }

    public function setCorreo(string $correo): void
    {
        $this->correo = $correo;
    }

    public function crear(): bool
    {
        $sql = 'INSERT INTO tiendas (nombre, direccion, telefono, correo)
                VALUES (:nombre, :direccion, :telefono, :correo)';
        $statement = Database::getConnection()->prepare($sql);
        $created = $statement->execute($this->datos());

        if ($created) {
            $this->id = (int) Database::getConnection()->lastInsertId();
        }

        return $created;
    }

    /** @return list<self> */
    public static function obtenerTodas(): array
    {
        $statement = Database::getConnection()->query(
            'SELECT id, nombre, direccion, telefono, correo FROM tiendas ORDER BY nombre, id'
        );

        return array_map(self::desdeFila(...), $statement->fetchAll());
    }

    public static function buscarPorId(int $id): ?self
    {
        $statement = Database::getConnection()->prepare(
            'SELECT id, nombre, direccion, telefono, correo FROM tiendas WHERE id = :id'
        );
        $statement->execute(['id' => $id]);
        $row = $statement->fetch();

        return $row === false ? null : self::desdeFila($row);
    }

    public function actualizar(): bool
    {
        if ($this->id === null) {
            return false;
        }

        $statement = Database::getConnection()->prepare(
            'UPDATE tiendas
             SET nombre = :nombre, direccion = :direccion, telefono = :telefono, correo = :correo
             WHERE id = :id'
        );

        return $statement->execute($this->datos() + ['id' => $this->id]);
    }

    public static function eliminar(int $id): bool
    {
        $statement = Database::getConnection()->prepare('DELETE FROM tiendas WHERE id = :id');

        return $statement->execute(['id' => $id]);
    }

    /** @return array{nombre: string, direccion: string, telefono: string, correo: string} */
    private function datos(): array
    {
        return [
            'nombre' => $this->nombre,
            'direccion' => $this->direccion,
            'telefono' => $this->telefono,
            'correo' => $this->correo,
        ];
    }

    /** @param array{id: int|string, nombre: string, direccion: ?string, telefono: ?string, correo: ?string} $row */
    private static function desdeFila(array $row): self
    {
        $tienda = new self(
            $row['nombre'],
            $row['direccion'] ?? '',
            $row['telefono'] ?? '',
            $row['correo'] ?? ''
        );
        $tienda->id = (int) $row['id'];

        return $tienda;
    }
}
