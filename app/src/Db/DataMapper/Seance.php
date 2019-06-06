<?php

namespace App\Db\DataMapper;

use DateTime;

/**
 * Class Seance
 * @package App\Db\DataMapper
 */
class Seance
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $filmId;

    /**
     * @var int
     */
    private $hallId;

    /**
     * @var DateTime
     */
    private $seanceTime;

    /**
     * @var int
     */
    private $price;

    /**
     * Seance constructor.
     * @param int $filmId
     * @param int $hallId
     * @param DateTime $seanceTime
     * @param int $price
     */
    public function __construct(int $filmId, int $hallId, DateTime $seanceTime, int $price)
    {
        $this->setFilmId($filmId);
        $this->setHallId($hallId);
        $this->setSeanceTime($seanceTime);
        $this->setPrice($price);
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
     * @return Seance
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return int
     */
    public function getFilmId(): int
    {
        return $this->filmId;
    }

    /**
     * @param int $filmId
     * @return Seance
     */
    public function setFilmId(int $filmId): self
    {
        $this->filmId = $filmId;

        return $this;
    }

    /**
     * @return int
     */
    public function getHallId(): int
    {
        return $this->hallId;
    }

    /**
     * @param int $hallId
     * @return Seance
     */
    public function setHallId(int $hallId): self
    {
        $this->hallId = $hallId;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getSeanceTime(): DateTime
    {
        return $this->seanceTime;
    }

    /**
     * @param DateTime $seanceTime
     * @return Seance
     */
    public function setSeanceTime(DateTime $seanceTime): self
    {
        $this->seanceTime = $seanceTime;

        return $this;
    }

    /**
     * @return int
     */
    public function getPrice(): int
    {
        return $this->price;
    }

    /**
     * @param int $price
     * @return Seance
     */
    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getId() . ', ' . $this->getFilmId() . ', ' . $this->getHallId() . ', ' .
            $this->getSeanceTime()->format('Y-m-d H:i:s') . ', ' .
            $this->getPrice();
    }
}
