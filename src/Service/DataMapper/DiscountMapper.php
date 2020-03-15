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
        $this->selectStatement = $this->pdo->prepare('SELECT * FROM discounts WHERE promocode = :promocode');
    }

    public function findByPromocode(string $promocode): ?Discount
    {
        $this->selectStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStatement->execute([
            'promocode' => $promocode
        ]);

        if (($result = $this->selectStatement->fetch()) === false) {
            return null;
        }

        $discount = new Discount();
        $discount->setId((int)$result['id']);
        $discount->setPromocode($result['promocode']);
        $discount->setValue((int)$result['value']);

        return $discount;
    }
}
