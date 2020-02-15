<?php declare(strict_types=1);

namespace Entity\Shop;

class Customer implements \JsonSerializable
{
    private int $id;

    private string $name;

    private string $address;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): void
    {
        $this->address = $address;
    }

    public function handleArray(array $customer): void
    {
        if (isset($customer['name'])) {
            $this->setName($customer['name']);
        }
        if (isset($customer['address'])) {
            $this->setAddress($customer['address']);
        }
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'address' => $this->getAddress()
        ];
    }
}
