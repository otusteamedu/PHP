<?php declare(strict_types=1);

namespace Service\DataMapper;

use Entity\Shop\Product;

class ProductMapper
{
    private \PDO $pdo;

    private \PDOStatement $selectStatement;

    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStatement = $this->pdo->prepare('SELECT * FROM products WHERE id = :id');
    }

    public function findById(int $id): ?Product
    {
        $this->selectStatement->setFetchMode(\PDO::FETCH_ASSOC);
        $this->selectStatement->execute([
            'id' => $id
        ]);

        if (($result = $this->selectStatement->fetch()) === false) {
            return null;
        }

        $product = new Product();
        $product->setId((int)$result['id']);
        $product->setTitle($result['title']);
        $product->setSum((float)$result['sum']);

        return $product;
    }
}
