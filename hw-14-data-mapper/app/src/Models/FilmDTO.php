<?php

namespace App\Models;

class FilmDTO
{
    /**
     * @var string
     */
    public string $title;

    /**
     * @var string
     */
    public string $showStartDate;

    /**
     * @var int
     */
    public int $lenght;

    /**
     * FilmDTO constructor.
     *
     * @param string $title
     * @param string $showStartDate
     * @param int    $lenght
     */
    public function __construct (
        string $title,
        string $showStartDate,
        int $lenght
    )
    {
        $this->name          = $title;
        $this->showStartDate = $showStartDate;
        $this->lenght        = $lenght;
    }
}