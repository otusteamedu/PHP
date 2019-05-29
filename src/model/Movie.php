<?php

namespace crazydope\theater\model;

class Movie
{
    protected $id = 0;
    protected $title = '';
    protected $description = '';

    public function exchangeArray(array $data): void
    {
        $this->id = $data['id'] ?? 0;
        $this->title = $data['title'] ?? '';
        $this->description = $data['description'] ?? '';
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
     * @return Movie
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
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
     * @return Movie
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
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
     * @return Movie
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => (int) $this->id,
            'title' => $this->title,
            'description' => $this->description
        ];
    }
}