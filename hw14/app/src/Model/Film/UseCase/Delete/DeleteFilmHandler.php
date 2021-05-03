<?php

declare(strict_types=1);

namespace App\Model\Film\UseCase\Delete;

use App\Model\Film\DataMapper\FilmMapperInterface;
use App\Model\Film\Entity\FilmId;

class DeleteFilmHandler
{
    private FilmMapperInterface $filmMapper;

    public function __construct(FilmMapperInterface $filmMapper)
    {
        $this->filmMapper = $filmMapper;
    }

    public function handle(DeleteFilmCommand $command): void
    {
        $filmId = new FilmId($command->id);

        $film = $this->filmMapper->getOne($filmId);

        $this->filmMapper->delete($film);
    }
}