<?php

namespace TimGa\DbPatterns\Model\LazyLoad;

class Movie
{
    private $pdo;
    private $movieId;
    private $name;
    public $scheduleCollection = null;
    private static $selectMovieByIdQuery = "SELECT name FROM movie WHERE movie_id = ?";
    private $selectSchedulesByMovieIdStmt;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectSchedulesByMovieIdStmt = $pdo->prepare("SELECT schedule_id, movie_id, begin_time, hall_id, price FROM schedule WHERE movie_id = ?");
    }

    public static function getMovieById(\PDO $pdo, int $movieId): self
    {
        $stmt = $pdo->prepare(self::$selectMovieByIdQuery);
        $stmt->execute([$movieId]);
        $stmt->setFetchMode(\PDO::FETCH_ASSOC);
        $result = $stmt->fetch();

        return (new self($pdo))
            ->setMovieId($movieId)
            ->setName($result['name']);
    }

    public function getScheduleCollection(): ScheduleCollection
    {
        if (is_null($this->scheduleCollection)) {
            $this->scheduleCollection = $this->loadScheduleCollection($this->movieId);
        }
        return $this->scheduleCollection;
    }

    private function loadScheduleCollection($movieId): ScheduleCollection
    {
        $this->selectSchedulesByMovieIdStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectSchedulesByMovieIdStmt->execute([$movieId]);
        $result = $this->selectSchedulesByMovieIdStmt->fetchAll();

        $scheduleCollection = new ScheduleCollection();

        foreach ($result as $row) {
            $schedule = Schedule::createFromArray($row);
            $scheduleCollection->append($schedule);
        }

        return $scheduleCollection;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}
