<?php

declare(strict_types=1);

namespace App\Command\Film;

use App\Command\CommandInterface;
use App\Console\Console;
use App\Model\Film\DataMapper\FilmMapperInterface;

class GetAllCommand implements CommandInterface
{
    private FilmMapperInterface $filmMapper;

    public function __construct(FilmMapperInterface $filmMapper)
    {
        $this->filmMapper = $filmMapper;
    }

    public function execute(): void
    {
        if (!$filmCollection = $this->filmMapper->getAll()) {
            Console::info('Список фильмов пуст');

            return;
        }

        Console::success('Список фильмов получен: ');
        foreach ($filmCollection as $film) {
            Console::info(print_r($film->toArray(), true));
        }
    }
}