<?php declare(strict_types=1);

namespace Service\DataMapper;

use Entity\Shop\Customer;

class CustomerMapper
{
    private \PDO $pdo;

    private \PDOStatement $insertStatement;

    private \PDOStatement $updateStatement;

    private \PDOStatement $deleteStatement;

    private \PDOStatement $selectStatement;

    private \PDOStatement $selectAllStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectAllStatement = $this->pdo->prepare('SELECT * FROM customers LIMIT :limit');
        $this->selectStatement = $this->pdo->prepare('SELECT * FROM customers WHERE id = :id');
        $this->insertStatement = $this->pdo->prepare('INSERT INTO customers (name, address) VALUES (:name, :address)');
        $this->updateStatement = $this->pdo->prepare('UPDATE customers SET name = :name, address = :address WHERE id = :id');
        $this->deleteStatement = $this->pdo->prepare('DELETE FROM customers WHERE id = :id');
    }

    /**
     * @param int $limit
     * @return array|Customer[]
     */
    public function findAll(int $limit = 10): array
    {
        $this->selectAllStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectAllStatement->execute([
            'limit' => $limit
        ]);
        $customers = [];
        foreach ($this->selectAllStatement->fetchAll() as $result) {
            $customer = new Customer();
            $customer->setId($result['id']);
            $customer->setName($result['name']);
            $customer->setAddress($result['address']);
            $customers[] = $customer;
        }

        return $customers;
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
        $customer->setId($result['id']);
        $customer->setName($result['name']);
        $customer->setAddress($result['address']);

        return $customer;
    }

    public function insert(Customer $customer): Customer
    {
        $this->insertStatement->execute([
            'name' => $customer->getName(),
            'address' => $customer->getAddress()
        ]);
        $customer->setId((int)$this->pdo->lastInsertId());

        return $customer;
    }

    public function update(Customer $customer): bool
    {
        return $this->updateStatement->execute([
            'id' => $customer->getId(),
            'name' => $customer->getName(),
            'address' => $customer->getAddress()
        ]);
    }

    public function delete(Customer $customer): bool
    {
        return $this->deleteStatement->execute([
            'id' => $customer->getId()
        ]);
    }
}
