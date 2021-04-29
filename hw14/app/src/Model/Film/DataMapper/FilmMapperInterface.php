<?php

declare(strict_types=1);

namespace App\Model\Film\DataMapper;

use App\Model\Film\Entity\Film;
use App\Model\Film\Entity\FilmCollection;
use App\Model\Film\Entity\FilmId;

interface FilmMapperInterface
{
    public function getAll(): FilmCollection;

    public function getOne(FilmId $id): Film;

    public function add(Film $film): void;

    public function delete(Film $film): void;
}