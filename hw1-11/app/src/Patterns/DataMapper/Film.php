<?php
namespace Src\Patterns\DataMapper;

/**
 * Class Film
 *
 * @package Src\Patterns\DataMapper
 */
class Film
{
    private int $id;

    private string $name;

    private string $year;

    private string $country;

    private string $description;

    /**
     * Film constructor.
     *
     * @param int $id
     * @param string $name
     * @param string $year
     * @param string $country
     * @param string $description
     */
    public function __construct(
        int $id,
        string $name,
        string $year,
        string $country,
        string $description
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->year = $year;
        $this->country = $country;
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
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

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getYear(): string
    {
        return $this->year;
    }

    /**
     * @param string $year
     */
    public function setYear(string $year): self
    {
        $this->year = $year;
        return $this;
    }

    /**
     * @return int|string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param int|string $country
     */
    public function setCountry($country): self
    {
        $this->country = $country;
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
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }
}