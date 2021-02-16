<?php


namespace Otushw;


/**
 * Class ContentDTO
 *
 * @package Otushw
 */
class ContentDTO
{
    /**
     * @var string
     */
    public string $name;

    /**
     * @var int
     */
    public int $id_genre;

    /**
     * @var int
     */
    public int $age_limit;

    /**
     * @var int
     */
    public int $move_lenght;

    /**
     * Content constructor.
     *
     * @param string $name
     * @param int    $id_genre
     * @param int    $age_limit
     * @param int    $move_lenght
     */
    public function __construct(
        string $name,
        int $id_genre,
        int $age_limit,
        int $move_lenght
    )
    {
        $this->name = $name;
        $this->id_genre = $id_genre;
        $this->age_limit = $age_limit;
        $this->move_lenght = $move_lenght;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "Name: $this->name, ID_genre: $this->id_genre, "
            . "Age limit: $this->age_limit, Move lenght: $this->move_lenght";
    }

}