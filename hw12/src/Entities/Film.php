<?php

declare(strict_types=1);

namespace RowDataGateway\Entities;

use RowDataGateway\Finders\GenreFinder;
use RowDataGateway\Gateways\FilmGateway;

/**
 * @property FilmGateway $gateway
 */
class Film extends AbstractEntity
{
    /**
     * @var int
     */
    protected $id;
    /**
     * @var string
     */
    protected $title;
    /**
     * @var int
     */
    protected $year;
    /**
     * @var Genre[]|null
     */
    protected $genres = null;
    /**
     * @var GenreFinder
     */
    private $genreFinder;

    /**
     * @param FilmGateway $gateway
     * @param GenreFinder $genreFinder
     * @param array $attrs
     */
    public function __construct(FilmGateway $gateway, GenreFinder $genreFinder, array $attrs = [])
    {
        parent::__construct($gateway, $attrs);
        $this->genreFinder = $genreFinder;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Film
     */
    public function setTitle(string $title): Film
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return int
     */
    public function getYear(): int
    {
        return $this->year;
    }

    /**
     * @param int $year
     * @return Film
     */
    public function setYear(int $year): Film
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @return Genre[]
     */
    public function genres(): array
    {
        // Lazy Load
        if ($this->genres === null) {
            $this->genres = $this->genreFinder->findByFilm($this->id);
        }

        return $this->genres;
    }

    /**
     * @return int
     */
    public function save(): int
    {
        if ($this->id !== null) {
            throw new \RuntimeException('Film already saved.');
        }

        $this->passAttributesToGateway();

        $this->id = $this->gateway->insert();

        return $this->id;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        $this->passAttributesToGateway();

        return $this->gateway->update();
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $result = $this->gateway->delete();

        if ($result === true) {
            $this->id = null;
            $this->genres = null;
        }

        return $result;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'year' => $this->year,
        ];
    }

    /**
     * @param Genre $genre
     */
    public function addGenre(Genre $genre): void
    {
        foreach ($this->genres() as $filmGenre) {
            if ($filmGenre->getId() === $genre->getId()) {
                throw new \InvalidArgumentException('Film already has this genre.');
            }
        }

        $result = $this->gateway->attachGenre($genre->getId());

        if ($result === false) {
            throw new \RuntimeException('Error occurred while adding new genre.');
        }

        $this->genres[] = $genre;
    }

    private function passAttributesToGateway(): void
    {
        $this->gateway->title = $this->title;
        $this->gateway->year = $this->year;
    }
}
