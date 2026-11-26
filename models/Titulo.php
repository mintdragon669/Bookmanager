<?php
declare(strict_types=1);

class Titulo
{
    private ?int $idTitulo = null;
    private string $titulo;
    private float $precio;
    private ?int $idPub;

    public function __construct(
        string $titulo = '',
        float $precio = 0.0,
        ?int $idPub = null,
        ?int $idTitulo = null
    ) {
        $this->titulo = $titulo;
        $this->precio = $precio;
        $this->idPub = $idPub;
        $this->idTitulo = $idTitulo;
    }

    public function getIdTitulo(): ?int
    {
        return $this->idTitulo;
    }

    public function getTitulo(): string
    {
        return $this->titulo;
    }

    public function setTitulo(string $titulo): void
    {
        $this->titulo = $titulo;
    }

    public function getPrecio(): float
    {
        return $this->precio;
    }

    public function setPrecio(float $precio): void
    {
        $this->precio = $precio;
    }

    public function getIdPub(): ?int
    {
        return $this->idPub;
    }

    public function setIdPub(?int $idPub): void
    {
        $this->idPub = $idPub;
    }

    public function crear(): bool
    {
        $statement = Database::getConnection()->prepare(
            'INSERT INTO titulos (titulo, precio, id_pub) VALUES (:titulo, :precio, :id_pub)'
        );
        $created = $statement->execute($this->datos());

        if ($created) {
            $this->idTitulo = (int) Database::getConnection()->lastInsertId();
        }

        return $created;
    }

    /** @return list<array{id_pub: int, nombre_pub: string}> */
    public static function obtenerPublicadores(): array
    {
        $statement = Database::getConnection()->query(
            'SELECT id_pub, nombre_pub FROM publicadores ORDER BY nombre_pub, id_pub'
        );

        return array_map(
            static fn (array $row): array => [
                'id_pub' => (int) $row['id_pub'],
                'nombre_pub' => (string) $row['nombre_pub'],
            ],
            $statement->fetchAll()
        );
    }

    /** @return list<array{id_titulo: int, titulo: string, precio: string, id_pub: int, nombre_pub: string}> */
    public static function obtenerTodos(): array
    {
        $statement = Database::getConnection()->query(
            'SELECT t.id_titulo, t.titulo, t.precio, t.id_pub, p.nombre_pub
             FROM titulos t
             INNER JOIN publicadores p ON p.id_pub = t.id_pub
             ORDER BY t.titulo, t.id_titulo'
        );

        return $statement->fetchAll();
    }

    /** @return array{id_titulo: int, titulo: string, precio: string, id_pub: int, nombre_pub: string}|null */
    public static function buscarPorId(int $id): ?array
    {
        $statement = Database::getConnection()->prepare(
            'SELECT t.id_titulo, t.titulo, t.precio, t.id_pub, p.nombre_pub
             FROM titulos t
             INNER JOIN publicadores p ON p.id_pub = t.id_pub
             WHERE t.id_titulo = :id'
        );
        $statement->execute(['id' => $id]);
        $row = $statement->fetch();

        return $row === false ? null : $row;
    }

    public function actualizar(): bool
    {
        if ($this->idTitulo === null) {
            return false;
        }

        $statement = Database::getConnection()->prepare(
            'UPDATE titulos SET titulo = :titulo, precio = :precio, id_pub = :id_pub
             WHERE id_titulo = :id_titulo'
        );

        return $statement->execute($this->datos() + ['id_titulo' => $this->idTitulo]);
    }

    public static function eliminar(int $id): bool
    {
        $statement = Database::getConnection()->prepare(
            'DELETE FROM titulos WHERE id_titulo = :id_titulo'
        );

        return $statement->execute(['id_titulo' => $id]);
    }

    /** @return array{titulo: string, precio: float, id_pub: int|null} */
    private function datos(): array
    {
        return [
            'titulo' => $this->titulo,
            'precio' => $this->precio,
            'id_pub' => $this->idPub,
        ];
    }
}
