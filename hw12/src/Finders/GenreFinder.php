<?php

declare(strict_types=1);

namespace RowDataGateway\Finders;

use PDO;
use PDOStatement;
use RowDataGateway\Entities\Genre;
use RowDataGateway\Gateways\GenreGateway;

class GenreFinder extends AbstractFinder
{
    /**
     * @var PDOStatement
     */
    protected $findByIdStmt;
    /**
     * @var PDOStatement
     */
    protected $findByFilmStmt;
    /**
     * @var GenreGateway
     */
    private $gateway;

    /**
     * @param PDO $pdo
     * @param GenreGateway $gateway
     */
    public function __construct(PDO $pdo, GenreGateway $gateway)
    {
        parent::__construct($pdo);

        $this->gateway = $gateway;

        $this->findByIdStmt = $this->pdo->prepare('select id, title from genres where ?');
        $this->findByFilmStmt = $this->pdo->prepare(
            'select id, title from genres g inner join films_has_genres fhg on g.id = fhg.genre_id where fhg.film_id=?'
        );
    }

    /**
     * @return Genre[]
     */
    public function all(): array
    {
        $stmt = $this->pdo->query('select id, title from genres');

        $genres = [];

        foreach ($stmt->fetchAll() as $row) {
            $genres[] = new Genre($this->gateway, $row);
        }

        return $genres;
    }

    /**
     * @return Genre|null
     */
    public function first(): ?Genre
    {
        $stmt = $this->pdo->query('select id, title from genres limit 1');

        $data = $stmt->fetch();

        if ($data === false) {
            return null;
        }

        return new Genre($this->gateway, $data);
    }

    /**
     * @param int $id
     * @return Genre|null
     */
    public function findById(int $id): ?Genre
    {
        $this->findByIdStmt->execute([$id]);

        $data = $this->findByIdStmt->fetch();

        if ($data === false) {
            return null;
        }

        return new Genre($this->gateway, $data);
    }

    /**
     * @param int $filmId
     * @return Genre[]
     */
    public function findByFilm(int $filmId): array
    {
        $this->findByFilmStmt->execute([$filmId]);

        $genres = [];

        foreach ($this->findByFilmStmt->fetchAll() as $row) {
            $genres[] = new Genre($this->gateway, $row);
        }

        return $genres;
    }
}
