<?php

namespace App\RelationModels;

use App\Entities\Film;
use App\Repositories\FilmsRepository;
use App\Repositories\SeancesRepository;
use Otus\DBConnection;

class FilmsSeancesRelation
{
    /**
     * @var FilmsRepository
     */
    private FilmsRepository $filmRepository;

    /**
     * @var SeancesRepository
     */
    private SeancesRepository $seancesRepository;

    public function __construct()
    {
        $this->filmRepository = new FilmsRepository(DBConnection::getInstance());
        $this->seancesRepository = new SeancesRepository(DBConnection::getInstance());
    }

    /**
     * @param Film $film
     * @return array|null
     * @throws \Exception
     */
    public function getSeancesByFilm(Film $film)
    {
        return $this->seancesRepository->getSeancesByFilmId($film->getId());
    }
}
