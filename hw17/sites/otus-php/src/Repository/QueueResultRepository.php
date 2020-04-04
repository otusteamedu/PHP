<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\QueueResult\QueueResult;
use App\Exceptions\ExistClassException;
use App\Exceptions\KernelException;
use App\DataBase\DataMapper;
use ReflectionException;

class QueueResultRepository implements RepositoryInterface
{
    /**
     * @var DataMapper
     */
    private $dataMapper;

    private $entity;

    /**
     * @param QueueResult $queueResult
     * @throws ExistClassException
     * @throws KernelException
     * @throws ReflectionException
     */
    public function __construct(QueueResult $queueResult)
    {
        $this->entity = $queueResult;
        $this->dataMapper = DataMapper::create($this->entity);
    }

    /**
     * @param array $filter
     * @return iterable
     * @throws \Exception
     */
    public function find(array $filter): iterable
    {
        return $this->dataMapper->find($filter);
    }

    /**
     * @param int $id
     * @return object
     * @throws \Exception
     */
    public function findById(int $id): object
    {
        return $this->dataMapper->findById($id);
    }
}
