<?php

namespace App\EntityRepository;

use App\Entity\Discount;
use App\EntityFilter\DiscountFilter as Filter;
use App\EntityInterface\IEntity;
use PDO;
use PDOStatement;

class DiscountRepository extends CommonEntityRepository
{
    /**
     * @param PDO $pdo
     * @return PDOStatement
     */
    protected static function getSelectStatement(PDO $pdo): PDOStatement
    {
        return $pdo->prepare(
            'select id, label, val, percents from discounts d left join discounts_orders_rel r on d.id = r.discount_id where (d.id = :'
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
            'insert into discounts (id, label, val, percents) values (:id, :label, :val, :percents);'
        );
    }

    /**
     * @return PDOStatement
     */
    protected function getUpdateStatement(): PDOStatement
    {
        return $this->pdo->prepare(
            'update discounts set label = :label, val = :val, percents = :percents where id = :'
            . Filter::ID . ';'
        );
    }

    /**
     * @return PDOStatement
     */
    protected function getDeleteStatement(): PDOStatement
    {
        return $this->pdo->prepare(
            'delete from discounts where id = :' . Filter::ID . ';'
        );
    }

    /**
     * @param PDO   $pdo
     * @param array $row
     * @return IEntity
     */
    protected static function buildEntityFromRow(PDO $pdo, array $row): IEntity
    {
        return (new Discount($pdo))->setId($row['id'])
                                   ->setLabel($row['label'])
                                   ->setValue($row['val'])
                                   ->setPercents($row['percents']);
    }

    /**
     * @param IEntity|Discount $discount
     * @return array
     */
    protected function fetchParams(IEntity $discount): array
    {
        return [
            'id'       => $discount->getId(),
            'label'    => $discount->getLabel(),
            'val'      => $discount->getValue(),
            'percents' => $discount->getPercents(),
        ];
    }
}