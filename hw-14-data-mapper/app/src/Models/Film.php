<?php

namespace App\Models;

class Film
{
    private int    $id;
    private string $title;
    private string $showStartDate;
    private int    $length;

    /**
     * Film constructor.
     *
     * @param int    $id
     * @param string $title
     * @param string $showStartDate
     * @param int    $length
     */
    public function __construct (
        int $id,
        string $title,
        string $showStartDate,
        int $length
    )
    {
        $this->id            = $id;
        $this->title         = $title;
        $this->showStartDate = $showStartDate;
        $this->length        = $length;
    }

    /**
     * @return int
     */
    public function getId (): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId (int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getTitle (): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle (string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getShowStartDate (): string
    {
        return $this->showStartDate;
    }

    /**
     * @param string $showStartDate
     */
    public function setIdGenre (string $showStartDate): void
    {
        $this->showStartDate = $showStartDate;
    }

    /**
     * @return int
     */
    public function getLength (): int
    {
        return $this->length;
    }

    /**
     * @param int $length
     */
    public function setLength (int $length): void
    {
        $this->length = $length;
    }
}