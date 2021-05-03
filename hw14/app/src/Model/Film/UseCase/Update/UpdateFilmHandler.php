<?php

declare(strict_types=1);

namespace App\Model\Film\UseCase\Update;

use App\Model\Film\DataMapper\FilmMapperInterface;
use App\Model\Film\Entity\FilmId;
use Exception;

class UpdateFilmHandler
{
    private FilmMapperInterface $filmMapper;

    public function __construct(FilmMapperInterface $filmMapper)
    {
        $this->filmMapper = $filmMapper;
    }

    /**
     * @throws Exception
     */
    public function handle(UpdateFilmCommand $command): void
    {
        $film = $this->filmMapper->getOne(new FilmId($command->id));

        $film->changeName($command->name);
        $film->changeProductionYear($command->productionYear);

        $this->filmMapper->update($film);
    }
}