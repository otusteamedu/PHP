<?php

namespace TimGa\DbPatterns\Model\LazyLoad;

class Schedule
{
    private $scheduleId;
    private $movieId;
    private $beginTime;
    private $hallId;
    private $price;

    public static function createFromArray($scheduleData): self
    {
        return (new self)
            ->setScheduleId($scheduleData['schedule_id'])
            ->setMovieId($scheduleData['movie_id'])
            ->setBeginTime($scheduleData['begin_time'])
            ->setHallId($scheduleData['hall_id'])
            ->setPrice($scheduleData['price']);
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
