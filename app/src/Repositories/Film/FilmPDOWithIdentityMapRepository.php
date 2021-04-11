<?php


namespace App\Repositories\Film;


use App\Entities\Entity;
use App\Entities\Film;
use App\Services\IdentityMap\EntityStorage;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class FilmPDOWithIdentityMapRepository extends FilmPDORepository
{
    protected EntityStorage $entityStorage;

    public function __construct()
    {
        $this->entityStorage = EntityStorage::getInstance();
        parent::__construct();
    }

    /**
     * @param array|string[] $columns
     * @return Collection|Film[]
     */
    public function getAll(array $columns = ['*']): Collection
    {
        $collection = parent::getAll($columns);

        foreach ($collection as $film){
            $this->entityStorage->add($film);
        }

        return $collection;
    }

    /**
     * @param int $id
     * @param array $columns
     * @return Film
     */
    public function getById(int $id, array $columns = ['*']): Film
    {
        $film = $this->entityStorage->get(Film::class, $id);

        if(!is_null($film)){
            return $film;
        }

        $film = parent::getById($id);

        $this->entityStorage->add($film);

        return $film;
    }

    /**
     * @param Film $film
     * @return bool
     */
    public function update(Entity $film): bool
    {
        $film->setUpdatedAt(Carbon::now());

        if(false === $this->entityStorage->update($film)){
            $this->entityStorage->add($film);
        }

        return parent::update($film);
    }

    /**
     * @param array $entityData
     * @return Film
     */
    public function insert(array $entityData): Film
    {
        $film = parent::insert($entityData);

        $this->entityStorage->add($film);

        return $film;
    }

    /**
     * @param Entity $film
     * @return bool
     */
    public function delete(Entity $film): bool
    {
        $this->entityStorage->remove($film);

        return parent::delete($film);
    }
}