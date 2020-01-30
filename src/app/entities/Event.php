<?php

namespace Entity;

use Repository\CommonRepository;
use Repository\EventsRepository;

class Event extends EventsRepository
{
    /** @var string $title */
    protected string $title = "";

    /** @var string $description */
    protected string $description = "";

    /**
     * @return string
     */
    protected function getKey(): string
    {
        return $this->title;
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
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
}