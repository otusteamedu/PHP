<?php

namespace App\Db\DataMapper;

/**
 * Class Film
 * @package App\Db\RowGateway
 */
class Film
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * Film constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->setName($name);
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
     * @return Seance
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param int $filmId
     * @return Seance
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->getId() . ', ' . $this->getName();
    }
}
