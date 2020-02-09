<?php

namespace Entity;

use Entity\Filter\IFilters;
use PDO;

class Genre extends Entity
{
    private string $name;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Genre
     */
    public function setName(string $name): Genre
    {
        $this->name = $name;
        return $this;
    }

    public static function getById(PDO $pdo, int $id): IEntities
    {
        return new self();
    }

    public static function getByFilter(
        PDO $pdo,
        IFilters $filter
    ): array {
        $st = $pdo->prepare(
            'select id, name from genres where (id = :id or :id = \'\') 
                              and (id in (select genre_id from movies_genres where movie_id = :movie_id) or :movie_id = \'\');'
        );
        if ($st->execute($filter->fetch())) {
            return array_map(
                fn(array $row) => (new static($pdo))->build($row),
                $st->fetchAll()
            );
        }
        return [];
    }

    /**
     * @return array
     */
    public function fetchArray(): array
    {
        return [
            'id'   => $this->getId(),
            'name' => $this->name,
        ];
    }

    /**
     * @param array $row
     * @return $this
     */
    public function build(array $row): self
    {
        return (new static())->setId($row['id'])->setName($row['name']);
    }

    /**
     * @return bool
     */
    public function create(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return false;
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return false;
    }
}