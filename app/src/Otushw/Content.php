<?php


namespace Otushw;


/**
 * Class Content
 *
 * @package Otushw
 */
class Content
{
    private int $id;
    private string $name;
    private int $id_genre;
    private int $age_limit;
    private int $move_lenght;

    /**
     * Content constructor.
     *
     * @param int    $id
     * @param string $name
     * @param int    $id_genre
     * @param int    $age_limit
     * @param int    $move_lenght
     */
    public function __construct(
        int $id,
        string $name,
        int $id_genre,
        int $age_limit,
        int $move_lenght
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->id_genre = $id_genre;
        $this->age_limit = $age_limit;
        $this->move_lenght = $move_lenght;
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
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return int
     */
    public function getIdGenre(): int
    {
        return $this->id_genre;
    }

    /**
     * @param int $id_genre
     */
    public function setIdGenre(int $id_genre): void
    {
        $this->id_genre = $id_genre;
    }

    /**
     * @return int
     */
    public function getAgeLimit(): int
    {
        return $this->age_limit;
    }

    /**
     * @param int $age_limit
     */
    public function setAgeLimit(int $age_limit): void
    {
        $this->age_limit = $age_limit;
    }

    /**
     * @return int
     */
    public function getMoveLenght(): int
    {
        return $this->move_lenght;
    }

    /**
     * @param int $move_lenght
     */
    public function setMoveLenght(int $move_lenght): void
    {
        $this->move_lenght = $move_lenght;
    }


}