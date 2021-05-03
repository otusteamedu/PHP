<?php

declare(strict_types=1);

namespace App\Command\Film;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Film\DataMapper\FilmMapperInterface;
use App\Model\Film\Entity\FilmId;

class GetOneCommand implements CommandInterface
{
    private FilmMapperInterface $filmMapper;

    public function __construct(FilmMapperInterface $filmMapper)
    {
        $this->filmMapper = $filmMapper;
    }

    public function execute(): void
    {
        $id = Console::getArgument(2);

        $filmId = new FilmId($id);

        $film = $this->filmMapper->getOne($filmId);

        Console::success('Информация о фильме получена:');
        Console::success(print_r($film->toArray(), true));
    }
}