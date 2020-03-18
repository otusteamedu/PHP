<?php declare(strict_types=1);

namespace Service\DataMapper;

use Entity\Shop\Customer;

class CustomerMapper
{
    private \PDO $pdo;

    private \PDOStatement $selectStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $this->pdo->prepare('SELECT * FROM customers WHERE id = :id');
    }

    public function findById(int $id): ?Customer
    {
        $this->selectStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStatement->execute([
            'id' => $id
        ]);
        if (($result = $this->selectStatement->fetch()) === false) {
            return null;
        }

        $customer = new Customer();
        $customer->setId((int)$result['id']);
        $customer->setName($result['name']);
        $customer->setAddress($result['address']);

        return $customer;
    }
}
