<?php

namespace TimGa\FillDb;

class DataEraser
{
    private $pdo;

    /**
     * Clear all data in ticket, schedule and movie tables, and reset corresponding sequences
     */
    public function start()
    {
        $this->pdo = Db::connect();
        $this->eraseTicket();
        $this->eraseSchedule();
        $this->eraseMovie();
        $this->pdo = null;
    }

    public function eraseTicket()
    {
        $sql = "delete from ticket where 1=1;";
        $stmt = $this->pdo->query($sql);
        if (!$stmt) {
            throw new \Exception("Error deleting from ticket");
        }
        $sql = "alter sequence ticket_ticket_id_seq restart with 1;";
        $stmt = $this->pdo->query($sql);
        if (!$stmt) {
            throw new \Exception("Error resetting ticket_id sequence");
        }
    }

    public function eraseSchedule()
    {
        $sql = "delete from schedule where 1=1;";
        $stmt = $this->pdo->query($sql);
        if (!$stmt) {
            throw new \Exception("Error deleting from schedule");
        }
        $sql = "alter sequence schedule_schedule_id_seq restart with 1;";
        $stmt = $this->pdo->query($sql);
        if (!$stmt) {
            throw new \Exception("Error resetting schedule_id sequence");
        }
    }

    public function eraseMovie()
    {
        $sql = "delete from movie where 1=1;";
        $stmt = $this->pdo->query($sql);
        if (!$stmt) {
            throw new \Exception("Error deleting from movie");
        }
        $sql = "alter sequence movie_movie_id_seq restart with 1;";
        $stmt = $this->pdo->query($sql);
        if (!$stmt) {
            throw new \Exception("Error resetting movie_id sequence");
        }
    }
}
