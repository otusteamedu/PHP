<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Film\Film;
use App\Exceptions\ExistClassException;
use App\DataBase\DataMapper;
use App\Exceptions\KernelException;
use ReflectionException;

class FilmRepository implements RepositoryInterface
{
    /**
     * @var DataMapper
     */
    private $dataMapper;

    private $entity;

    /**
     * @throws ReflectionException
     * @throws ExistClassException
     * @throws KernelException
     */
    public function __construct(Film $film)
    {
        $this->entity = $film;
        $this->dataMapper = new DataMapper($this->entity);
    }

    /**
     * @param array $filter
     * @return iterable
     * @throws ReflectionException
     */
    public function find(array $filter): iterable
    {
        return $this->dataMapper->find($filter);
    }

    /**
     * @param int $id
     * @return object
     * @throws ReflectionException
     */
    public function findById(int $id): object
    {
        return $this->dataMapper->findById($id);
    }
}
