<?php

namespace App\EntityRepository;

use App\Entity\DeliveryService;
use App\EntityFilter\DiscountFilter as Filter;
use App\EntityInterface\IEntity;
use PDO;
use PDOStatement;

class DeliveryServiceRepository extends CommonEntityRepository
{
    /**
     * @param PDO $pdo
     * @return PDOStatement
     */
    protected static function getSelectStatement(PDO $pdo): PDOStatement
    {
        return $pdo->prepare(
            'select id, name, price from delivery_services s left join delivery_services_orders_rel r on s.id = r.delivery_id where (s.id = :'
            . Filter::ID . ' or :' . Filter::ID . ' = 0) and (r.order_id = :'
            . Filter::ORDER . ' or :' . Filter::ORDER . ' = 0);'
        );
    }

    /**
     * @return PDOStatement
     */
    protected function getCreateStatement(): PDOStatement
    {
        return $this->pdo->prepare(
            'insert into delivery_services(id, name, price) values(:id, :name, :price);'
        );
    }

    /**
     * @return PDOStatement
     */
    protected function getUpdateStatement(): PDOStatement
    {
        return $this->pdo->prepare(
            'update delivery_services set name = :name, price = :price where id = :'
            . Filter::ID . ';'
        );
    }

    /**
     * @return PDOStatement
     */
    protected function getDeleteStatement(): PDOStatement
    {
        return $this->pdo->prepare(
            'delete from delivery_services where id = :' . Filter::ID . ';'
        );
    }

    /**
     * @param PDO   $pdo
     * @param array $row
     * @return DeliveryService
     */
    protected static function buildEntityFromRow(
        PDO $pdo,
        array $row
    ): DeliveryService {
        return (new DeliveryService($pdo))->setId($row['id'])->setPrice(
            $row['price']
        )->setName($row['name']);
    }

    /**
     * @param IEntity|DeliveryService $service
     * @return array
     */
    protected function fetchParams(IEntity $service): array
    {
        return [
            'id'    => $service->getId(),
            'name'  => $service->getName(),
            'price' => $service->getPrice(),
        ];
    }
}