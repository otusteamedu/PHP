<?php

namespace App\Repositories\Film;

use App\Entities\Film;
use Illuminate\Support\Collection;

interface FilmRepository
{
    /**
     * @param array|string[] $columns
     *      $columns[
     *          '*' (default)
     *         'id',
     *         'name',
     *         'description',
     *         'age_restrict',
     *         'duration',
     *         'created_at',
     *         'updated_at',
     *     ]
     * @return Collection|Film[]
     */
    public function getAll(array $columns = ['*']) : Collection;

    /**
     * @param int $id
     * @param array|string[] $columns
     *     $columns[
     *          '*' (default)
     *         'id',
     *         'name',
     *         'description',
     *         'age_restrict',
     *         'duration',
     *         'created_at',
     *         'updated_at',
     *     ]
     * @return Film
     */
    public function getById(int $id, array $columns = ['*']) : Film;

    public function update(Film $film) : bool;

    /**
     * @param array $entityData
     *      $entityData[
     *         'id' => int (optional) autoincrement,
     *         'name' => string,
     *         'description' => string (optional),
     *         'age_restrict' => int,
     *         'duration' => string (time, format H:i),
     *         'created_at' => string (datetime, format Y-m-d H:i:s),
     *         'updated_at' => string (datetime, format Y-m-d H:i:s),
     *      ]
     * @return Film
     */
    public function insert(array $entityData) : Film;

    public function delete(Film $film) : bool;
}