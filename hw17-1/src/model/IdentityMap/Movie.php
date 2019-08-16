<?php

namespace TimGa\DbPatterns\Model\IdentityMap;

class Movie
{
    private $movieId;
    private $name;

    public function getMovieId()
    {
        return $this->movieId;
    }

    public function setMovieId($movieId): self
    {
        $this->movieId = $movieId;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }
}
