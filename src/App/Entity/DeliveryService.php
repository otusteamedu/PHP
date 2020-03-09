<?php

namespace App\Entity;

use App\EntityFilter\DeliveryServiceFilter;
use App\EntityInterface\IDeliveryService;
use App\EntityInterface\IEntity;
use App\EntityInterface\IFetchAssoc;
use App\EntityRepository\DeliveryServiceRepository;
use App\EntityFilter\IEntityFilter;
use PDO;

class DeliveryService extends CommonEntity
    implements IDeliveryService, IFetchAssoc
{
    private string $name = '';
    private float $price = 0.0;

    /**
     * DeliveryService constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->repository = new DeliveryServiceRepository($pdo);
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param PDO           $pdo
     * @param IEntityFilter $filter
     * @return IDeliveryService[]
     */
    public static function getEntitiesByFilter(
        PDO $pdo,
        IEntityFilter $filter
    ): array {
        return DeliveryServiceRepository::getEntitiesByFilter($pdo, $filter);
    }

    /**
     * @param PDO $pdo
     * @param int $id
     * @return DeliveryService
     */
    public static function getById(PDO $pdo, int $id): IEntity
    {
        return self::getEntitiesByFilter(
                $pdo,
                new DeliveryServiceFilter($id)
            )[0] ?? new DeliveryService($pdo);
    }

    public function fetchToAssoc(): array
    {
        return [
            'name'  => $this->name,
            'price' => $this->price,
        ];
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
     * @return DeliveryService
     */
    public function setName(string $name): DeliveryService
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param float $price
     * @return DeliveryService
     */
    public function setPrice(float $price): DeliveryService
    {
        $this->price = $price;
        return $this;
    }
}