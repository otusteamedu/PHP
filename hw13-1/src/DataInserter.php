<?php

namespace TimGa\FillDb;

class DataInserter
{
    const SESSIONS_PER_DAY = 15;
    const FILMS_PER_WEEK = 5;
    const DAYS_IN_WEEK = 7;
    const NUM_OF_HALLS = 3;
    const NUM_OF_SEATS = 100;
    const TICKETS_BOUGHT_PERCENT = 85;

    public $pdo;
    public $generator;

    public function __construct()
    {
        $this->pdo = Db::connect();
        $this->generator = new DataGenerator;
    }

    public function closeDbConnection()
    {
        $this->pdo = null;
    }

    public function insertMovies(int $numOfMovies)
    {
        for ($i = 0; $i < $numOfMovies; $i++) {
            $movieName = $this->generator->generateMovie();
            $sql = "INSERT INTO movie (name) VALUES ('" . $movieName . "');";
            $stmt = $this->pdo->query($sql);
            if (!$stmt) {
                throw new \Exception("Error inserting into movie table");
            }
        }
    }

    public function insertScheduleAndTickets(int $numOfMovies)
    {
        $numOfDays = self::DAYS_IN_WEEK * ($numOfMovies / self::FILMS_PER_WEEK);
        $date = new \DateTime();
        $scheduleId = 0;
        for ($i = 0; $i < $numOfDays; $i++) {  // iterate days
            for ($j = 10; $j <= 24; $j++) {  // iterate hours
                $hour = $j;
                $scheduleId++;
                $movieBeginDate = $date->format('Y-m-d');
                $movieBeginDateTime = $movieBeginDate . ' ' . $hour . ':00:00';
                $movieId = $this->generator->generateMovieId($numOfMovies);
                $hallId = $this->generator->generateHallId(self::NUM_OF_HALLS);
                $price = $this->generator->generatePrice($hour);
                $sql = "INSERT INTO schedule (movie_id, begin_time, hall_id, price) VALUES ('$movieId','$movieBeginDateTime','$hallId','$price')";
                $stmt = $this->pdo->query($sql);
                if (!$stmt) {
                    throw new \Exception("Error inserting into schedule table");
                }
                $this->insertTickets($scheduleId, $hallId);
            }
            $date->modify('+ 1 day');
            $percentsCompleted = min(100, round(((100 * ($scheduleId * self::FILMS_PER_WEEK) / (self::SESSIONS_PER_DAY * self::DAYS_IN_WEEK) + 1) / $numOfMovies), 2));
            echo "completed: $percentsCompleted %" . PHP_EOL;
        }
    }

    private function insertTickets($scheduleId, $hallId)
    {
        $seatIdMin = $this->generator->generateSeatIdMin($hallId);
        $seatIdMax = $this->generator->generateSeatIdMax($hallId);
        $values = [];
        $questionMarks = [];
        for ($i = $seatIdMin; $i <= $seatIdMax; $i++) {
            $seatId = $i;
            $ticketStatusId = $this->generator->generateTicketStatusId(self::TICKETS_BOUGHT_PERCENT);
            $values[] = $ticketStatusId;
            $values[] = $scheduleId;
            $values[] = $seatId;
            $questionMarks[] = '(?,?,?)';
        }
        $questionMarks = implode(",", $questionMarks);
        $sql = "INSERT INTO ticket (ticket_status_id, schedule_id, seat_id) VALUES " . $questionMarks;
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($values);
        if (!$stmt) {
            throw new \Exception("Error inserting into ticket table");
        }
    }
}
