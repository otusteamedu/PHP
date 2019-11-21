<?php
namespace App;

use PDOStatement;

class ProductActiveRecord
{
    /**
     * @var DBConnectorInterface
     */
    private $dbConnection;
    /**
     * @var DBQueriesInterface
     */
    private $queries;

    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $description;
    /**
     * @var int
     */
    private $price;

    /**
     * @var string
     */
    private $tableName = 'products';

    /**
     * @var array
     */
    private $tableFields = ['title', 'description', 'price'];

    /**
     * @var PDOStatement
     */
    private $insertStmt;
    /**
     * @var PDOStatement
     */
    private $updateStmt;
    /**
     * @var PDOStatement
     */
    private $deleteStmt;

    /**
     * ProductActiveRecord constructor.
     * @param DBConnectorInterface $dbConnection
     * @param DBQueriesInterface $queries
     */
    public function __construct(DBConnectorInterface $dbConnection, DBQueriesInterface $queries)
    {
        $this->dbConnection = $dbConnection->connect();
        $this->queries = $queries;

        // prepare statements
        $this->insertStmt = $this->dbConnection->prepare($this->queries->insert($this->tableName, $this->tableFields));
        $this->updateStmt = $this->dbConnection->prepare($this->queries->update($this->tableName, $this->tableFields));
        $this->deleteStmt = $this->dbConnection->prepare($this->queries->delete($this->tableName));
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
     * @param int $productId
     * @return ProductActiveRecord
     */
    public function findByID(int $productId): self
    {
        $selectStmt = $this->dbConnection->prepare($this->queries->findByID($this->tableName));
        $selectStmt->execute([$productId]);
        $result = $selectStmt->fetch();

        return $this
            ->setId($result['id'])
            ->setTitle($result['title'])
            ->setDescription($result['description'])
            ->setPrice($result['price']);
    }

    /**
     * @return array
     */
    public function findAll(): array
    {
        $selectStmt = $this->dbConnection->prepare($this->queries->findAll($this->tableName));
        $selectStmt->execute();
        $result = $selectStmt->fetchAll();

        $products = [];

        foreach ($result as $product) {
            $products[] = $this
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