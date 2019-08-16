<?php

namespace TimGa\DbPatterns\Model\TableGateway;

class Schedule
{
    private $pdo;
    private $insertStmt;
    private $selectByMovieIdStmt;
    private $updateStmt;
    private $deleteByScheduleIdStmt;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->insertStmt = $pdo->prepare("INSERT INTO schedule (movie_id, begin_time, hall_id, price) VALUES (:movie_id, :begin_time, :hall_id, :price)");
        $this->selectByMovieIdStmt = $pdo->prepare("SELECT schedule_id, movie_id, begin_time, hall_id, price FROM schedule WHERE movie_id = ?");
        $this->updateStmt = $pdo->prepare("UPDATE schedule SET movie_id = :movie_id, begin_time = :begin_time, hall_id = :hall_id, price = :price WHERE schedule_id = :schedule_id");
        $this->deleteByScheduleIdStmt = $pdo->prepare("DELETE FROM schedule WHERE schedule_id = ?");
    }

    public function insert(array $data): int
    {
        $this->insertStmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    public function selectByMovieId(int $movie_id): array
    {
        $this->selectByMovieIdStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectByMovieIdStmt->execute([$movie_id]);
        return $this->selectByMovieIdStmt->fetchAll();
    }

    public function update(array $data)
    {
        return $this->updateStmt->execute($data);
    }

    public function deleteByScheduleId($scheduleId): bool
    {
        return $this->deleteByScheduleIdStmt->execute([$scheduleId]);
    }
}