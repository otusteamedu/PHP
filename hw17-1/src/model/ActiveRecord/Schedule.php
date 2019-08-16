<?php

namespace TimGa\DbPatterns\Model\ActiveRecord;

class Schedule
{
    private $pdo;
    private $scheduleId;
    private $movieId;
    private $beginTime;
    private $hallId;
    private $price;
    private $insertStmt;
    private $updateStmt;
    private $deleteStmt;
    private static $selectScheduleByIdQuery = "SELECT movie_id, begin_time, hall_id, price FROM schedule WHERE schedule_id = ?";

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->insertStmt = $pdo->prepare("INSERT INTO schedule (movie_id, begin_time, hall_id, price) VALUES (?, ?, ?, ?)");
        $this->updateStmt = $pdo->prepare("UPDATE schedule SET movie_id = ?, begin_time = ?, hall_id = ?, price = ? WHERE schedule_id = ?");
        $this->deleteStmt = $pdo->prepare("DELETE FROM schedule WHERE schedule_id = ?");
    }

    public function insert(): bool
    {
        $result = $this->insertStmt->execute([
            $this->movieId,
            $this->beginTime,
            $this->hallId,
            $this->price,
        ]);
        $this->scheduleId = $this->pdo->lastInsertId();
        return $result;
    }

    public function update(): bool
    {
        return $this->updateStmt->execute([
            $this->movieId,
            $this->beginTime,
            $this->hallId,
            $this->price,
            $this->scheduleId,
        ]);
    }

    public function delete(): bool
    {
        $result = $this->deleteStmt->execute([$this->scheduleId]);
        $this->scheduleId = null;
        return $result;
    }

    public static function getScheduleById(\PDO $pdo, $scheduleId): self
    {
        $stmt = $pdo->prepare(self::$selectScheduleByIdQuery);
        $stmt->execute([$scheduleId]);
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $result = $stmt->fetch();
        return (new self($pdo))
            ->setScheduleId($scheduleId)
            ->setMovieId($result['movie_id'])
            ->setBeginTime($result['begin_time'])
            ->setHallId($result['hall_id'])
            ->setPrice($result['price']);
    }

    public function isTheSameMovie(self $schedule): bool
    {
        return $this->movieId === $schedule->getMovieId();
    }

    public function getScheduleId(): int
    {
        return $this->scheduleId;
    }

    public function setScheduleId(int $scheduleId): self
    {
        $this->scheduleId = $scheduleId;
        return $this;
    }

    public function getMovieId(): int
    {
        return $this->movieId;
    }

    public function setMovieId(int $movieId): self
    {
        $this->movieId = $movieId;
        return $this;
    }

    public function getBeginTime(): string
    {
        return $this->beginTime;
    }

    public function setBeginTime(string $beginTime): self
    {
        $this->beginTime = $beginTime;
        return $this;
    }

    public function getHallId(): int
    {
        return $this->hallId;
    }

    public function setHallId(int $hallId): self
    {
        $this->hallId = $hallId;
        return $this;
    }

    public function getPrice(): int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;
        return $this;
    }
}
