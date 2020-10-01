<?php


namespace App\Entities;


use Carbon\Carbon;

class Seance
{
    /**
     * @var int
     */
    private int $id;

    /**
     * @var int
     */
    private int $film_id;

    /**
     * @var float
     */
    private float $price;

    /**
     * @var Carbon
     */
    private Carbon $start_at;

    public function __construct(int $id, int $film_id, float $price, Carbon $start_at)
    {
        $this->id = $id;
        $this->film_id = $film_id;
        $this->price = $price;
        $this->start_at = $start_at;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getFilmId(): int
    {
        return $this->film_id;
    }

    /**
     * @param int $film_id
     */
    public function setFilmId(int $film_id): void
    {
        $this->film_id = $film_id;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @return Carbon
     */
    public function getStartAt(): Carbon
    {
        return $this->start_at;
    }

    /**
     * @param Carbon $start_at
     */
    public function setStartAt(Carbon $start_at): void
    {
        $this->start_at = $start_at;
    }

}
