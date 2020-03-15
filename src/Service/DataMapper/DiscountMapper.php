<?php declare(strict_types=1);

namespace Service\DataMapper;

use Entity\Shop\Discount;

class DiscountMapper
{
    private \PDO $pdo;

    private \PDOStatement $selectStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $this->pdo->prepare('SELECT * FROM discounts WHERE id = :id');
    }

    public function findById(int $id): ?Discount
    {
        $this->selectStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStatement->execute([
            'id' => $id
        ]);

        if (($result = $this->selectStatement->fetch()) === false) {
            return null;
        }

        $discount = new Discount();
        $discount->setId((int)$result['id']);
        $discount->setPromocode($result['promocode']);
        $discount->setValue($result['value']);

        return $discount;
    }
}
