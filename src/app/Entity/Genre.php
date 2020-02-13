<?php

namespace App\Entity;

use App\Entity\Filter\GenresFilter;
use PDO;
use PDOStatement;

class Genre extends Entity
{
    private string $name;
    private PDOStatement $createStatement;
    private PDOStatement $updateStatement;
    private PDOStatement $deleteStatement;

    protected static string
        $selectQuery = 'select id, name from genres 
                where (id = :id or :id = \'\') 
                    and (id in (select genre_id from movies_genres where movie_id = :movie_id) or :movie_id = \'\');';

    public function __construct(?PDO $pdo = null)
    {
        parent::__construct($pdo);
        if ($pdo instanceof PDO) {
            $this->createStatement = $pdo->prepare(
                'insert into genres (name) value (?)'
            );
            $this->updateStatement = $pdo->prepare(
                'update genres set name = ? where id = ?'
            );
            $this->deleteStatement = $pdo->prepare(
                'delete from genres where id = ?'
            );
        }
    }

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
        return self::getByFilter($pdo, new GenresFilter($id))[0] ??
               new static();
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
     * @param PDO   $pdo
     * @param array $row
     * @return $this
     */
    public static function initByRow(PDO $pdo, array $row): Entity
    {
        return static::getCache($row['id']) ?? static::putCache(
                (new static())->setId($row['id'])->setName($row['name'])
            );
    }

    /**
     * @return bool
     */
    public function create(): bool
    {
        if ($this->createStatement->execute([$this->name])) {
            self::putCache($this->setId($this->pdo->lastInsertId()));
            return true;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return static::putCache($this)->updateStatement->execute(
            [$this->name, $this->getId()]
        );
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return static::popCache($this)->deleteStatement->execute(
            [$this->getId()]
        );
    }
}