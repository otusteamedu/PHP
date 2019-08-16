<?php

namespace TimGa\DbPatterns\Model\DataMapper;

class ScheduleMapper
{
    private $pdo;
    private $selectStmt;
    private $insertStmt;
    private $updateStmt;
    private $deleteStmt;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStmt = $pdo->prepare("SELECT movie_id, begin_time, hall_id, price FROM schedule WHERE schedule_id = ?");
        $this->insertStmt = $pdo->prepare("INSERT INTO schedule (movie_id, begin_time, hall_id, price) VALUES (?, ?, ?, ?)");
        $this->updateStmt = $pdo->prepare("UPDATE schedule SET movie_id = ?, begin_time = ?, hall_id = ?, price = ? WHERE schedule_id = ?");
        $this->deleteStmt = $pdo->prepare("DELETE FROM schedule WHERE schedule_id = ?");
    }

    public function findById($scheduleId): Schedule
    {
        $this->selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStmt->execute([$scheduleId]);
        $result = $this->selectStmt->fetch();
        return new Schedule(
            $scheduleId,
            $result['movie_id'],
            $result['begin_time'],
            $result['hall_id'],
            $result['price']
        );
    }

    public function insert(array $scheduleData): Schedule
    {
        $this->insertStmt->execute([
            $scheduleData['movie_id'],
            $scheduleData['begin_time'],
            $scheduleData['hall_id'],
            $scheduleData['price'],
        ]);
        $scheduleId = $this->pdo->lastInsertId();
        return new Schedule(
            $scheduleId,
            $scheduleData['movie_id'],
            $scheduleData['begin_time'],
            $scheduleData['hall_id'],
            $scheduleData['price']
        );
    }

    public function update(Schedule $schedule): bool
    {
       return $this->updateStmt->execute([
           $schedule->getMovieId(),
           $schedule->getBeginTime(),
           $schedule->getHallId(),
           $schedule->getPrice(),
           $schedule->getScheduleId(),
       ]);
    }

    public function delete(Schedule $schedule): bool
    {
        return $this->deleteStmt->execute([$schedule->getScheduleId()]);
    }

}