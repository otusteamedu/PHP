<?php

namespace App\Repositories\Film;

use App\Entities\Film;
use Illuminate\Support\Collection;

interface FilmRepository
{
    /**
     * @return Collection|Film[]
     */
    public function getAll() : Collection;

    /**
     * @param int $id
     * @return Film
     */
    public function getById(int $id) : Film;

    /**
     * @param Film $film
     * @return bool
     */
    public function update(Film $film) : bool;

    /**
     * @param array $entityData
     * @return Film
     */
    public function insert(array $entityData) : Film;

    /**
     * @param Film $film
     * @return bool
     */
    public function delete(Film $film) : bool;
}