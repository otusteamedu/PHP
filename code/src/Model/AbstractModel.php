<?php


namespace App\Model;


use App\Services\Orm\Interfaces\ModelInterface;


abstract class AbstractModel implements ModelInterface
{
    protected ?int $id = null;


    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }
}
