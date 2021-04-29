<?php

declare(strict_types=1);

namespace App\Model\Film\UseCase\Add;

use App\Model\Film\DataMapper\FilmMapperInterface;
use App\Model\Film\Entity\Film;
use App\Model\Film\Entity\FilmId;

class AddFilmHandler
{
    private FilmMapperInterface $filmMapper;

    public function __construct(FilmMapperInterface $filmMapper)
    {
        $this->filmMapper = $filmMapper;
    }

    public function handle(AddFilmCommand $command): void
    {
        $film = $this->buildFilm($command);

        $this->filmMapper->add($film);
    }

    private function buildFilm(AddFilmCommand $command): Film
    {
        $film = new Film(FilmId::next(), $command->name);

        $film->changeProductionYear($command->productionYear);

        return $film;
    }
}