<?php

namespace App\Db\LazyLoad;

use App\Db\Connect;
use DateTime;
use Exception;
use PDO;
use PDOStatement;

/**
 * Class SeanceRecord
 * @package App\Db\LazyLoad
 */
class SeanceRecord
{
    private const DOLLAR_K = 65.43;
    /**
     * @var PDO
     */
    private $pdo;

    /**
     * @var Connect
     */
    private $connect;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $filmId;

    /**
     * @var FilmRecord
     */
    private $film;

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
     * @var PDOStatement|bool
     */
    private $selectStmt;

    /**
     * @var PDOStatement|bool
     */
    private $insertStmt;

    /**
     * @var PDOStatement|bool
     */
    private $updateStmt;

    /**
     * @var PDOStatement|bool
     */
    private $deleteStmt;

    /**
     * @var bool
     */
    private $lazy;

    /**
     * ActiveRecord constructor.
     * @param Connect $connect
     */
    public function __construct(Connect $connect, bool $lazy =true)
    {
        $this->connect = $connect;
        $this->pdo = $connect->getPdo();
        $this->lazy = $lazy;

        $this->selectStmt = $this->pdo->prepare(
            'SELECT 
                seance.film_id, seance.hall_id, seance.seance_time, seance.price, 
                film.id as film_id, film.name as film_name 
                FROM seance 
                INNER join film ON seance.film_id = film.id 
                WHERE seance.id = ?'
        );

        $this->selectStmtLazy = $this->pdo->prepare(
            'SELECT film_id, hall_id, seance_time, price FROM seance WHERE id = ?'
        );

        $this->insertStmt = $this->pdo->prepare(
            'INSERT INTO seance (film_id, hall_id, seance_time, price) VALUES (?, ?, ?, ?)'
        );

        $this->updateStmt = $this->pdo->prepare(
            'UPDATE seance SET film_id = ?, hall_id = ?, seance_time = ?, price = ? WHERE id = ?'
        );

        $this->deleteStmt = $this->pdo->prepare(
            'DELETE FROM seance WHERE id = ?'
        );
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     * @return SeanceRecord
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
     * @return SeanceRecord
     */
    public function setFilmId(int $filmId): self
    {
        $this->filmId = $filmId;

        return $this;
    }

    /**
     * @return FilmRecord
     */
    public function getFilm()
    {
        if ($this->lazy) {
            $filmRecord = new FilmRecord($this->connect);
            $film = $filmRecord->findById($this->getFilmId());

            return $film;
        } else {
            return $this->film;
        }
    }

    public function setFilm(FilmRecord $film)
    {
        $this->film = $film;
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
     * @return SeanceRecord
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
     * @return SeanceRecord
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
     * @return SeanceRecord
     */
    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @param int $id
     * @return SeanceRecord
     * @throws Exception
     */
    public function findById(int $id): self
    {
        if ($this->lazy) {
            $this->selectStmtLazy->setFetchMode(PDO::FETCH_ASSOC);
            $this->selectStmtLazy->execute([$id]);
            $result = $this->selectStmtLazy->fetch();
        } else {
            $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
            $this->selectStmt->execute([$id]);
            $result = $this->selectStmt->fetch();

            $film = (new FilmRecord($this->connect))
                ->setId($result['film_id'])
                ->setName($result['film_name']);
            $this->setFilm($film);
        }

        return (new self($this->connect))
            ->setId($id)
            ->setFilmId($result['film_id'])
            ->setHallId($result['hall_id'])
            ->setSeanceTime(new DateTime($result['seance_time']))
            ->setPrice($result['price']);
    }

    /**
     * @param array $criteria
     * @return array
     */
    public function findBy(array $criteria)
    {
        $sql = 'SELECT id, film_id, hall_id, seance_time, price FROM seance';

        $where = [];
        foreach ($criteria as $field => $value) {
            $where[] = $field . ' = ?';
        }
        $sql .= ' WHERE ' . implode(' AND ', $where);

        $selectStmt = $this->pdo->prepare($sql);
        $selectStmt->setFetchMode(PDO::FETCH_ASSOC);
        $selectStmt->execute(array_values($criteria));

        $result = [];

        foreach ($selectStmt->fetchAll() as $item) {
            $result[] = (new self($this->connect))
                ->setId($item['id'])
                ->setFilmId($item['film_id'])
                ->setHallId($item['hall_id'])
                ->setSeanceTime(new DateTime($item['seance_time']))
                ->setPrice($item['price']);
        }

        return $result;
    }

    /**
     * @return int
     */
    public function insert(): bool
    {
        $result = $this->insertStmt->execute([
            $this->getFilmId(),
            $this->getHallId(),
            $this->getSeanceTime()->format('Y-m-d H:i:s'),
            $this->getPrice(),
        ]);

        $this->setId($this->pdo->lastInsertId());

        return $result;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->updateStmt->execute([
            $this->getFilmId(),
            $this->getHallId(),
            $this->getSeanceTime()->format('Y-m-d H:i:s'),
            $this->getPrice(),
            $this->getId()
        ]);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $result = $this->deleteStmt->execute([$this->getId()]);
        $this->setId(null);

        return $result;
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

    /**
     * @return float
     */
    public function getDollarPrice(): float
    {
        return $this->getPrice() * self::DOLLAR_K;
    }
}