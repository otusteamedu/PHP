<?php

namespace App\Entity;

use App\EntityInterface\IEntity;
use App\EntityRepository\IEntityRepository;

abstract class CommonEntity implements IEntity
{
    protected int $id = 0;
    protected IEntityRepository $repository;

    /**
     * @return bool
     */
    public function create(): bool
    {
        return $this->repository->create($this);
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->repository->update($this);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        return $this->repository->delete($this);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return static
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }
}