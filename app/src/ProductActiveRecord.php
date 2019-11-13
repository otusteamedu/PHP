<?php
namespace App;

class ProductActiveRecord
{
    private $dbConnection;
    private $id;
    private $title;
    private $description;
    private $price;

    public function __construct(\PDO $dbConnection)
    {
        $this->dbConnection = $dbConnection;

        $this->insertStmt = $dbConnection->prepare(
            "insert into products (title, description, price) values (?, ?, ?)"
        );
        $this->updateStmt = $dbConnection->prepare(
            "update products set title = ?, description = ?, price = ? where id = ?"
        );
        $this->deleteStmt = $dbConnection->prepare("delete from products where id = ?");
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return ProductActiveRecord
     */
    public function setId($id): ProductActiveRecord
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return ProductActiveRecord
     */
    public function setTitle($title): ProductActiveRecord
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return ProductActiveRecord
     */
    public function setDescription($description): ProductActiveRecord
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     * @return ProductActiveRecord
     */
    public function setPrice($price): ProductActiveRecord
    {
        $this->price = $price;
        return $this;
    }

    /**
     * @param \PDO $dbConnection
     * @param int $productId
     * @return ProductActiveRecord
     */
    public static function find(\PDO $dbConnection, int $productId): self
    {
        $selectStmt = $dbConnection->prepare("select * from products where id = ?");
        $selectStmt->execute([$productId]);
        $result = $selectStmt->fetch();

        return (new self($dbConnection))
            ->setId($result['id'])
            ->setTitle($result['title'])
            ->setDescription($result['description'])
            ->setPrice($result['price']);
    }

    /**
     * @param \PDO $dbConnection
     * @return array
     */
    public static function findAll(\PDO $dbConnection): array
    {
        $selectStmt = $dbConnection->prepare("select * from products");
        $selectStmt->execute();
        $result = $selectStmt->fetchAll();

        $products = [];

        foreach ($result as $product) {
            $products[] = (new self($dbConnection))
                ->setId($product['id'])
                ->setTitle($product['title'])
                ->setDescription($product['description'])
                ->setPrice($product['price']);
        }

        return $products;
    }

    /**
     * @return bool
     */
    public function insert(): bool
    {
        $result = $this->insertStmt->execute([
            $this->title,
            $this->description,
            $this->price,
        ]);
        $this->id = $this->dbConnection->lastInsertId();
        return $result;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->updateStmt->execute([
            $this->title,
            $this->description,
            $this->price,
            $this->id,
        ]);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $id = $this->id;
        $this->id = null;
        return $this->deleteStmt->execute([$id]);
    }

    /**
     * @return bool
     */
    public function isExpensive(): bool
    {
        return $this->price > 1000;
    }
}