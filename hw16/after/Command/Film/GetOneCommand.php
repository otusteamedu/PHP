<?php

declare(strict_types=1);

namespace App\Command\Film;

use App\Command\CommandInterface;
use App\Console\ConsoleInterface;
use App\Model\Film\DataMapper\FilmMapperInterface;
use App\Model\Film\Entity\FilmId;

class GetOneCommand implements CommandInterface
{
    private ConsoleInterface    $console;
    private FilmMapperInterface $filmMapper;

    public function __construct(ConsoleInterface $console, FilmMapperInterface $filmMapper)
    {
        $this->console = $console;
        $this->filmMapper = $filmMapper;
    }

    public function execute(): void
    {
        $id = $this->console->getArgument(2)->getValue();

        $filmId = new FilmId($id);

        $film = $this->filmMapper->getOne($filmId);

        $this->console->success('Информация о фильме получена:');
        $this->console->success(print_r($film->toArray(), true));
    }
}