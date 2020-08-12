<?php

namespace Models\Movies;


class Movie
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
     * @var string
     */
    private $creationDate;

    /**
     * @var string
     */
    private $trailer;

    /**
     * @var string
     */
    private $imageFolder;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $duration;

    /**
     * @var int
     */
    private $censor;

    public function __construct(
        ?int $id,
        string $name,
        string $creationDate,
        string $trailer,
        string $imageFolder,
        string $description,
        string $duration,
        int $censor
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->creationDate = $creationDate;
        $this->trailer = $trailer;
        $this->imageFolder = $imageFolder;
        $this->description = $description;
        $this->duration = $duration;
        $this->censor = $censor;
    }

    /**
     * @return int
     */
    public function getCensor(): int
    {
        return $this->censor;
    }

    /**
     * @param int $censor
     */
    public function setCensor(int $censor): self
    {
        $this->censor = $censor;
        return $this;
    }

    /**
     * @return string
     */
    public function getCreationDate(): string
    {
        return $this->creationDate;
    }

    /**
     * @param string $creationDate
     */
    public function setCreationDate(string $creationDate): self
    {
        $this->creationDate = $creationDate;

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

    /**
     * @return string
     */
    public function getDuration(): string
    {
        return $this->duration;
    }

    /**
     * @param string $duration
     */
    public function setDuration(string $duration): self
    {
        $this->duration = $duration;
        return $this;
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
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getImageFolder(): string
    {
        return $this->imageFolder;
    }

    /**
     * @param string $imageFolder
     */
    public function setImageFolder(string $imageFolder): self
    {
        $this->imageFolder = $imageFolder;
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
     * @param string $name
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getTrailer(): string
    {
        return $this->trailer;
    }

    /**
     * @param string $trailer
     */
    public function setTrailer(string $trailer): self
    {
        $this->trailer = $trailer;
        return $this;
    }
}

