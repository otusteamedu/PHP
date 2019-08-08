<?php

namespace hw15;

/**
 * Class EventItem
 * @package hw15
 */
class EventItem
{
    private $name;
    private $description;

    /**
     * EventItem constructor.
     * @param string $name
     * @param string $description
     */
    public function __construct(string $name, string $description)
    {
        $this->name = $name;
        $this->description = $description;
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

}