<?php


namespace Otushw;

use Iterator;

/**
 * Class ContentCollection
 *
 * @package Otushw
 */
class ContentCollection implements Iterator
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
    private array $raw = [];

    /**
     * ContentCollection constructor.
     *
     * @param array $raw
     */
    public function __construct(array $raw = [])
    {
        if (!empty($raw)) {
            $this->raw = $raw;
            $this->total = count($raw);
        }
    }

    /**
     * @param Content $content
     */
    public function add(Content $content): void
    {
        $id = $content->getId();
        $current = $this->getFromMap($id);
        if (!is_null($current)) {
            $content = $current;
        }

        $this->objects[$this->total] = $content;
        $this->total++;
    }

    /**
     * @param int $num
     *
     * @return null|Content
     */
    private function getRow(int $num): ?Content
    {
        if ($num >= $this->total || $num < 0) {
            return null;
        }

        if (isset($this->objects[$num])) {
            return $this->objects[$num];
        }

        if (isset($this->raw[$num])) {
            $this->objects[$num] = $this->createContentObject($this->raw[$num]);
            return $this->objects[$num];
        }

        return null;
    }

    /**
     * @param array $raw
     *
     * @return Content
     */
    private function createContentObject(array $raw): Content
    {
        $current = $this->getFromMap($raw['id']);
        if (!is_null($current)) {
            return $current;
        }

        return new Content(
            $raw['id'],
            $raw['name'],
            $raw['id_genre'],
            $raw['age_limit'],
            $raw['move_lenght'],
        );
    }

    /**
     * @return Content
     */
    public function current(): ?Content
    {
        return $this->getRow($this->pointer);
    }

    /**
     * @return Content
     */
    public function next(): ?Content
    {
        $this->pointer++;
        return $this->current();
    }

    /**
     * @return int
     */
    public function key(): int
    {
        return $this->pointer;
    }

    /**
     * @return bool
     */
    public function valid(): bool
    {
        return (!is_null($this->current()));
    }

    /**
     *
     */
    public function rewind()
    {
        $this->pointer = 0;
    }

    /**
     * @param int $id
     *
     * @return Content|null
     */
    private function getFromMap(int $id): ?Content
    {
        return ContentWatcher::getItem($id);
    }
}
