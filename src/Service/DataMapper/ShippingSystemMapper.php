<?php declare(strict_types=1);

namespace Service\DataMapper;

use Entity\Shop\ShippingSystem;

class ShippingSystemMapper
{
    private \PDO $pdo;

    private \PDOStatement $selectStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $this->pdo->prepare('SELECT * FROM shipping_systems WHERE id = :id');
    }

    public function findById(int $id): ?ShippingSystem
    {
        $this->selectStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStatement->execute([
            'id' => $id
        ]);

        if (($result = $this->selectStatement->fetch()) === false) {
            return null;
        }

        $discount = new ShippingSystem();
        $discount->setId((int)$result['id']);
        $discount->setTitle($result['title']);
        $discount->setSum($result['sum']);

        return $discount;
    }
}
