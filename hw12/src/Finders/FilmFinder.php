<?php

declare(strict_types=1);

namespace RowDataGateway\Finders;

use PDO;
use PDOStatement;
use RowDataGateway\Entities\Film;
use RowDataGateway\Gateways\FilmGateway;

class FilmFinder extends AbstractFinder
{
    /**
     * @var PDOStatement
     */
    protected $findByIdStmt;
    /**
     * @var FilmGateway
     */
    private $gateway;
    /**
     * @var GenreFinder
     */
    private $genreFinder;

    public function __construct(PDO $pdo, FilmGateway $gateway, GenreFinder $genreFinder)
    {
        parent::__construct($pdo);

        $this->gateway = $gateway;
        $this->genreFinder = $genreFinder;

        $this->findByIdStmt = $this->pdo->prepare('select id, title, year from films where ?');
    }

    /**
     * @return Film[]
     */
    public function all(): array
    {
        $stmt = $this->pdo->query('select id, title, year from films');

        $films = [];

        foreach ($stmt->fetchAll() as $row) {
            $films[] = new Film($this->gateway, $this->genreFinder, $row);
        }

        return $films;
    }

    /**
     * @param int $id
     * @return Film|null
     */
    public function findById(int $id): ?Film
    {
        $this->findByIdStmt->execute([$id]);

        $data = $this->findByIdStmt->fetch();

        if ($data === false) {
            return null;
        }

        return new Film($this->gateway, $this->genreFinder, $data);
    }
}
