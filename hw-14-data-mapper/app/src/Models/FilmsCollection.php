<?php

namespace App\Models;

use Iterator;

class FilmsCollection implements Iterator
{
    /**
     * @var int
     */
    private int $pointer = 0;

    /**
     * @var int
     */
    private int $total = 0;

    /**
     * @var array
     */
    private array $objects = [];

    /**
     * @var array
     */
    private array $records = [];

    /**
     * FilmsCollection constructor.
     *
     * @param array $records
     */
    public function __construct (array $records = [])
    {
        if (!empty($records)) {
            $this->records = $records;
            $this->total   = count($records);
        }
    }

    /**
     * @param Film $film
     */
    public function add (Film $film): void
    {
        $this->objects[$this->total] = $film;
        $this->total++;
    }

    /**
     * @param int $num
     *
     * @return null|Film
     */
    private function getRow (int $num): ?Film
    {
        if ($num >= $this->total || $num < 0) {
            return null;
        }

        if (isset($this->objects[$num])) {
            return $this->objects[$num];
        }

        if (isset($this->records[$num])) {
            $this->objects[$num] = $this->createFilmObject($this->records[$num]);

            return $this->objects[$num];
        }

        return null;
    }

    /**
     * @param array $record
     *
     * @return Film
     */
    private function createFilmObject (array $record): Film
    {
        return new Film(
            $record['id'],
            $record['title'],
            $record['show_start_date'],
            $record['lenght'],
        );
    }

    /**
     * @return Film|null
     */
    public function current (): ?Film
    {
        return $this->getRow($this->pointer);
    }

    /**
     * @return Film|null
     */
    public function next (): ?Film
    {
        $this->pointer++;

        return $this->current();
    }

    /**
     * @return int
     */
    public function key (): int
    {
        return $this->pointer;
    }

    /**
     * @return bool
     */
    public function valid (): bool
    {
        return (!is_null($this->current()));
    }

    public function rewind ()
    {
        $this->pointer = 0;
    }

    public function getRecords (): array
    {
        return $this->records;
    }
}