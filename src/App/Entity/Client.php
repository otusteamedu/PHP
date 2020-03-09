<?php

namespace App\Entity;

use App\EntityFilter\ClientFilter;
use App\EntityFilter\IEntityFilter;
use App\EntityInterface\IClient;
use App\EntityInterface\IEntity;
use App\EntityInterface\IFetchAssoc;
use App\EntityRepository\ClientRepository;
use Exception;
use PDO;

class Client extends CommonEntity implements IClient, IFetchAssoc
{
    public const TYPE_B2B = 'b2b';
    public const TYPE_B2C = 'b2c';

    protected string $name = '';
    protected string $address = '';

    private string $type = self::TYPE_B2C;

    /**
     * CommonClient constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->repository = new ClientRepository($pdo);
        if ($this instanceof PrivateClient) {
            $this->type = self::TYPE_B2C;
        } elseif ($this instanceof CorporateClient) {
            $this->type = self::TYPE_B2B;
        }
    }

    /**
     * @param PDO    $pdo
     * @param string $type
     * @return PrivateClient|CorporateClient|Client
     * @throws Exception
     */
    public static function getClientByType(PDO $pdo, string $type): self
    {
        switch ($type) {
            case self::TYPE_B2B:
                return new CorporateClient($pdo);
            case self::TYPE_B2C:
                return new PrivateClient($pdo);
        }
        throw new Exception('client type is incorrect');
    }

    /**
     * @return array
     */
    public function fetchToAssoc(): array
    {
        return [
            'name'    => $this->name,
            'type'    => $this->type,
            'address' => $this->address,
        ];
    }

    /**
     * @inheritDoc
     */
    public static function getEntitiesByFilter(
        PDO $pdo,
        IEntityFilter $filter
    ): array {
        return ClientRepository::getEntitiesByFilter($pdo, $filter);
    }

    /**
     * @param PDO $pdo
     * @param int $id
     * @return Client|CorporateClient|PrivateClient
     */
    public static function getById(PDO $pdo, int $id): IEntity
    {
        return self::getEntitiesByFilter($pdo, new ClientFilter($id))[0] ??
               new Client($pdo);
    }

    /**
     * @param PDO $pdo
     * @return Order
     */
    public function createOrder(PDO $pdo): Order
    {
        $order = new Order($pdo, $this);
        $order->create();
        return $order;
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
     * @return static
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getAddress(): string
    {
        return $this->address;
    }

    /**
     * @param string $address
     * @return static
     */
    public function setAddress(string $address): self
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }
}