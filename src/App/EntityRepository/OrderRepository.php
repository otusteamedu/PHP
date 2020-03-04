<?php

namespace App\EntityRepository;

use App\Entity\Client;
use App\Entity\DeliveryService;
use App\Entity\Discount;
use App\Entity\Order;
use App\Entity\Product;
use App\EntityFilter\DeliveryServiceFilter;
use App\EntityFilter\DiscountFilter;
use App\EntityFilter\OrderFilter as Filter;
use App\EntityFilter\ProductFilter;
use App\EntityInterface\IEntity;
use PDO;
use PDOStatement;

class OrderRepository extends CommonEntityRepository
{
    /**
     * @inheritDoc
     */
    protected static function getSelectStatement(PDO $pdo): PDOStatement
    {
        return $pdo->prepare(
            'select o.id as id, client_id, state, date_created as date_created '
            . '  from orders o left join clients c on c.id = o.client_id  where (o.id = :'
            . Filter::ID . ' or :' . Filter::ID . ' = 0) and (o.client_id = :'
            . Filter::CLIENT . ' or :' . Filter::CLIENT
            . ' = 0) and (o.state = :' . Filter::STATE . ' or :' . Filter::STATE
            . ' = 0) and (c.type = :' . Filter::TYPE . ' or :' . Filter::TYPE
            . ' = \'\');'
        );
    }

    /**
     * @inheritDoc
     */
    protected function getCreateStatement(): PDOStatement
    {
        return $this->pdo->prepare(
            'insert into orders (id, client_id, state, date_created) values (:id, :client_id, :state, :date_created);'
        );
    }

    /**
     * @inheritDoc
     */
    protected function getUpdateStatement(): PDOStatement
    {
        return $this->pdo->prepare(
            'update orders set client_id = :client_id, state = :state,  date_created = :date_created where id = :'
            . Filter::ID . ';'
        );
    }

    /**
     * @inheritDoc
     */
    protected function getDeleteStatement(): PDOStatement
    {
        return $this->pdo->prepare(
            'delete from orders where id = :' . Filter::ID . ';'
        );
    }

    /**
     * @param PDO   $pdo
     * @param array $row
     * @return IEntity
     */
    protected static function buildEntityFromRow(PDO $pdo, array $row): IEntity
    {
        $order = new Order($pdo, Client::getById($pdo, $row['client_id']));
        $order->setId($row['id']);
        $order->setDtCreated($row['date_created']);
        $order->setState($row['state']);
        array_walk(
            DeliveryService::getEntitiesByFilter(
                $pdo,
                DeliveryServiceFilter::buildFromAssoc(
                    [DeliveryServiceFilter::ORDER => $row['id']]
                )
            ),
            fn(DeliveryService $service) => $order->getContents()
                                                  ->addDeliveryService($service)
        );
        array_walk(
            Product::getEntitiesByFilter(
                $pdo,
                ProductFilter::buildFromAssoc(
                    [ProductFilter::ORDER => $row['id']]
                )
            ),
            fn(Product $product) => $order->getContents()->addProduct($product)
        );
        array_walk(
            Discount::getEntitiesByFilter(
                $pdo,
                DiscountFilter::buildFromAssoc(
                    [DiscountFilter::ORDER => $row['id']]
                )
            ),
            fn(Discount $discount) => $order->getContents()->addDiscount(
                $discount
            )
        );
        return $order;
    }

    /**
     * @param IEntity|Order $entity
     * @return array
     */
    protected function fetchParams(IEntity $entity): array
    {
        return [
            'id'           => $entity->getId(),
            'client_id'    => $entity->getClient()->getId(),
            'state'        => $entity->getState(),
            'date_created' => $entity->getDtCreated(),
        ];
    }
}