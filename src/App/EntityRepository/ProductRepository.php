<?php

namespace App\EntityRepository;

use App\Entity\Product;
use App\EntityFilter\ProductFilter as Filter;
use App\EntityInterface\IEntity;
use PDO;
use PDOStatement;

class ProductRepository extends CommonEntityRepository
{
    /**
     * @inheritDoc
     */
    protected static function getSelectStatement(PDO $pdo): PDOStatement
    {
        return $pdo->prepare(
            'select id, title, price, weight from products p left join products_orders_rel r on p.id = r.product_id where (p.id = :'
            . Filter::ID . ' or :' . Filter::ID . ' = 0) and (p.price <= :'
            . Filter::MAX_PRICE . ' or :' . Filter::MAX_PRICE
            . ' = 0) and (p.price >= :' . Filter::MIN_PRICE . ' or :'
            . Filter::MIN_PRICE . ' = 0) and (p.weight <= :'
            . Filter::MAX_WEIGHT . ' or :' . Filter::MAX_WEIGHT
            . ' = 0) and (p.weight >= :' . Filter::MIN_WEIGHT . ' or :'
            . Filter::MIN_WEIGHT . ' = 0) and (r.order_id = :' . Filter::ORDER
            . ' or :' . Filter::ORDER . ' = 0);'
        );
    }

    /**
     * @inheritDoc
     */
    protected function getCreateStatement(): PDOStatement
    {
        return $this->pdo->prepare(
            'insert into products (id, title, price, weight) values (:id, :title, :price, :weight);'
        );
    }

    /**
     * @inheritDoc
     */
    protected function getUpdateStatement(): PDOStatement
    {
        return $this->pdo->prepare(
            'update products set title = :title, price = :price, weight = :weight where id = :'
            . Filter::ID . ';'
        );
    }

    /**
     * @inheritDoc
     */
    protected function getDeleteStatement(): PDOStatement
    {
        return $this->pdo->prepare(
            'delete from products where id = :' . Filter::ID . ';'
        );
    }

    /**
     * @param PDO   $pdo
     * @param array $row
     * @return IEntity
     */
    protected static function buildEntityFromRow(PDO $pdo, array $row): IEntity
    {
        return (new Product($pdo))->setId($row['id'])
                                  ->setTitle($row['title'])
                                  ->setPrice($row['price'])
                                  ->setWeight($row['weight']);
    }

    /**
     * @param IEntity|Product $product
     * @return array
     */
    protected function fetchParams(IEntity $product): array
    {
        return [
            'id'     => $product->getId(),
            'title'  => $product->getTitle(),
            'price'  => $product->getPrice(),
            'weight' => $product->getWeight(),
        ];
    }
}