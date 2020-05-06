<?php

namespace Ozycast\App\DTO;

use Ozycast\App\Core\DTO;

Class Channel extends DTO
{
    /**
     * @var string
     */
    private $id = "";
    /**
     * @var string
     */
    private $title = "";

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     * @return Channel
     */
    public function setId(string $id): self
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
     * @return Channel
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }
}