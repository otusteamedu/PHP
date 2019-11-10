<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class FilmGenreSeeder extends AbstractSeed
{
    public function run(): void
    {
        $this->clearTable();

        /** @var PDOStatement $stmt */
        $filmsStmt = $this->adapter->query('select id from films');
        $genresStmt = $this->adapter->query('select id from genres');

        $films = $filmsStmt->fetchAll(PDO::FETCH_ASSOC);
        $genres = $genresStmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($films as $film) {
            $randomGenres = array_rand($genres, mt_rand(2, 5));

            foreach ($randomGenres as $randomGenre) {
                $this->adapter->execute(
                    "insert into films_has_genres (film_id, genre_id) values({$film['id']}, {$genres[$randomGenre]['id']})"
                );
            }
        }
    }

    public function clearTable(): void
    {
        $this->adapter->execute('delete from films_has_genres');
    }
}
