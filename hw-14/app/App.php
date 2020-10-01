<?php

namespace App;

use App\Cli\Router;
use App\Repositories\FilmsRepository;
use App\Repositories\SeancesRepository;
use Otus\DBConnection;

class App
{
    private Router $router;
    private DBConnection $db;

    public function __construct()
    {
        $this->router = new Router();
        $this->db = new DBConnection();
    }

    public function run()
    {
//        $filmsRepository = new FilmsRepository($this->db);
//        $film = $filmsRepository->findById(1);
//        $film = $filmsRepository->insert([
//            'name' => 'Фильм 6',
//            'description' => 'Описание фильм 6',
//            'duration' => 120,
//            'age_limit' => 18
//        ]);
//        $film->setName('Фильм 6 upd');
//        $filmsRepository->update($film);
//        $filmsRepository->delete(9);
//        var_dump($film);

        $seancesRepository = new SeancesRepository($this->db);
        $seance = $seancesRepository->findById(1);
        $seance = $seancesRepository->insert([
            'film_id' => 1,
            'price' => 200,
            'start_at' => '2020-09-15 16:00:00'
        ]);
        $seance->setPrice(250);
        $seancesRepository->update($seance);
        $seancesRepository->delete(23);
//        var_dump($seance);
    }
}
