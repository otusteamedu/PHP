<?php

namespace TimGa\DbPatterns\Model\IdentityMap;

class MovieFinder
{
    private $pdo;
    private $selectStmt;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStmt = $pdo->prepare("SELECT name FROM movie WHERE movie_id = ?");
    }

    public function find($movieId): Movie
    {
        if (!$movie = MovieIdentityMap::getMovieFromMap($movieId)) {

            $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
            $this->selectStmt->execute([$movieId]);
            $result = $this->selectStmt->fetch();

            $movie = (new Movie)
                ->setMovieId($movieId)
                ->setName($result['name']);

            MovieIdentityMap::addMovieToMap($movieId, $movie);
        }
        return $movie;
    }
}
