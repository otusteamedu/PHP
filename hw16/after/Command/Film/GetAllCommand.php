<?php

declare(strict_types=1);

namespace App\Command\Film;

use App\Command\CommandInterface;
use App\Console\ConsoleInterface;
use App\Model\Film\DataMapper\FilmMapperInterface;

class GetAllCommand implements CommandInterface
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
        if (!$filmCollection = $this->filmMapper->getAll()) {
            $this->console->info('Список фильмов пуст');

            return;
        }

        $this->console->success('Список фильмов получен: ');
        foreach ($filmCollection as $film) {
            $this->console->info(print_r($film->toArray(), true));
        }
    }
}