<?php

namespace App\Entities;

class ClientEntity extends BaseEntity
{
    protected $id;
    protected $name;
    protected $address;

    /**
     * ClientEntity constructor.
     * @param string $name
     * @param string $address
     */
    public function __construct(
        string $name,
        string $address
    )
    {
        $this->name = $name;
        $this->address = $address;
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
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param string $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }
}