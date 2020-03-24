<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Ticket\Ticket;
use App\Exceptions\ExistClassException;
use App\Exceptions\KernelException;
use App\DataBase\DataMapper;
use ReflectionException;

class TicketRepository implements RepositoryInterface
{
    /**
     * @var DataMapper
     */
    private $dataMapper;

    private $entity;

    /**
     * @param Ticket $ticket
     * @throws ExistClassException
     * @throws KernelException
     * @throws ReflectionException
     */
    public function __construct(Ticket $ticket)
    {
        $this->entity = $ticket;
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

    /**
     * @param array $bookingData
     * @return bool
     */
    public function insertTickets(array $bookingData): bool
    {
        return $this->dataMapper->insertTickets($bookingData);
    }

    /**
     * @param array $bookingResult
     * @return bool
     */
    public function insertResult(array $bookingResult): bool
    {
        return $this->dataMapper->insertResult($bookingResult);
    }
}