<?php

namespace TimGa\DbPatterns\Model\RowGateway;

class MovieFinder
{
    private $pdo;
    private $selectStmt;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStmt = $pdo->prepare("SELECT name from movie where movie_id = ?");
    }

    public function findById(int $id): Movie
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$id]);
        $result = $this->selectStmt->fetch();

        return (new Movie($this->pdo))
            ->setMovieId($id)
            ->setName($result['name']);
    }
}