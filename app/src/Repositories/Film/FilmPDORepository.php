<?php


namespace App\Repositories\Film;


use App\Entities\Entity;
use App\Entities\Film;
use App\Repositories\BasePdoRepository;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class FilmPDORepository extends BasePdoRepository implements FilmRepository
{
    protected string $table = 'films';

    public function getAll(array $columns = ['*']): Collection
    {
        return parent::getAll($columns);
    }

    public function getById(int $id, array $columns = ['*']): Film
    {
        return parent::getById($id);
    }

    public function update(Entity $film): bool
    {
        $film->setUpdatedAt(Carbon::now());

        return parent::update($film);
    }

    public function insert(array $entityData): Film
    {
        $entityData['created_at'] = Carbon::now();
        $entityData['updated_at'] = Carbon::now();

        return parent::insert($entityData);
    }

    public function delete(Entity $film): bool
    {
        return parent::delete($film);
    }

    protected function mapEntity(array $entityData): Film
    {
        $entity = new Film();
        $entity->setId($entityData['id'] ?? 0);
        $entity->setName($entityData['name'] ?? '');
        $entity->setDescription($entityData['description'] ?? '');
        $entity->setAgeRestrict($entityData['age_restrict'] ?? 0);
        $entity->setDuration($entityData['duration'] ?? '');
        $entity->setCreatedAt($entityData['created_at'] ?? '');
        $entity->setUpdatedAt($entityData['updated_at'] ?? '');

        return $entity;
    }
}