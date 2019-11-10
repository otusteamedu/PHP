<?php

declare(strict_types=1);

use RowDataGateway\Entities\{Film, Genre};
use RowDataGateway\Gateways\FilmGateway;
use RowDataGateway\Finders\{FilmFinder, GenreFinder};

$container = require dirname(__FILE__) . '/config/container.php';

$films = $container[FilmFinder::class]->all();

$film = $films[0];

echo "Film data: id: {$film->getId()}, title: {$film->getTitle()}\n";

echo "Film genres:\n";
foreach ($film->genres() as $key => $genre) {
    echo sprintf("%d. %s\n", $key + 1, $genre->getTitle());
}

/**
 * Creating new film...
 */

$newFilm = new Film($container[FilmGateway::class], $container[GenreFinder::class]);

$newFilm->setTitle('Joker');
$newFilm->setYear(2019);
$newFilm->save();

echo "\nNew film saved (id: {$newFilm->getId()}, title: {$newFilm->getTitle()})\n\n";

/**
 * Adding a genre to the new film...
 */

/** @var Genre $genre */
$genre = $container[GenreFinder::class]->first();

$newFilm->addGenre($genre);

echo "New film genres:\n";
foreach ($newFilm->genres() as $key => $genre) {
    echo sprintf("%d. %s\n", $key + 1, $genre->getTitle());
}

/**
 * Updating the new film...
 */
$film->setTitle('The Secret Life of Pets 2');
$film->update();
echo "\nFilm updated ({$film->getTitle()})\n\n";

/**
 * Deleting the new film...
 */
$film->delete();
echo "Film deleted" . PHP_EOL;
