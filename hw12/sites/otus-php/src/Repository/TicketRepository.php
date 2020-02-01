<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Ticket\Ticket;
use App\Kernel\DataBase\DataMapper;
use ReflectionException;

class TicketRepository
{
    /**
     * @var DataMapper
     */
    private $dataMapper;

    private $entity;

    /**
     * @throws ReflectionException
     */
    public function __construct()
    {
        $this->entity = new Ticket();
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