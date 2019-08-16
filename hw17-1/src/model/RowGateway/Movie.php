<?php

namespace TimGa\DbPatterns\Model\RowGateway;

class Movie
{
    private $pdo;
    private $insertStmt;
    private $updateStmt;
    private $deleteStmt;
    private $name;
    private $movie_id;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->insertStmt = $pdo->prepare("INSERT INTO movie (name) VALUES (?)");
        $this->updateStmt = $pdo->prepare("UPDATE movie SET name = ? WHERE movie_id=?");
        $this->deleteStmt = $pdo->prepare("DELETE FROM movie WHERE movie_id=?");
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getMovieId(): int
    {
        return $this->movie_id;
    }

    public function setMovieId(int $movie_id): self
    {
        $this->movie_id = $movie_id;
        return $this;
    }

    public function insert(): int
    {
        $this->insertStmt->execute([
            $this->name,
        ]);
        return $this->pdo->lastInsertId();
    }

    public function update(): bool
    {
        return $this->updateStmt->execute([
            $this->name,
            $this->movie_id,
        ]);
    }

    public function delete(): bool
    {
        $result = $this->deleteStmt->execute([$this->movie_id]);
        $this->movie_id = null;
        return $result;
    }
}