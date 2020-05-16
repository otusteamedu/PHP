<?php
namespace Otus\ActiveRecord;

class Products {
    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var int
     */
    private $categoryId;

    /**
     * @var \PDOStatement
     */
    private static $selectQuery = "select name, description, category_id from products where id = ?";

    /**
     * @var \PDOStatement
     */
    private static $selectListQuery = "select * from products";

    /**
     * @var \PDOStatement
     */
    private $updateStmt;

    /**
     * @var \PDOStatement
     */
    private $insertStmt;

    /**
     * @var \PDOStatement
     */
    private $deleteStmt;

    /**
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->insertStmt = $pdo->prepare(
            "insert into products (name, description, category_id) values (?, ?, ?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update products set name = ?, description = ?, category_id = ? where id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from products where id = ?");
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Products
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Products
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Products
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @param int $catId
     * @return Products
     */
    public function setCategoryId(int $catId): self
    {
        $this->categoryId = $catId;
        return $this;
    }

    /**
     * @return string
     */
    public function getPageTitle(): string
    {
        return $this->getName() . ' - ' . $this->getCategoryId();
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getSeoText(): string
    {
        $date = new \DateTime('now');
        return $this->getDescription() . ' mysite.com, ' . $date->format('Y');
    }

    /**
     * @param \PDO $pdo
     * @param int $id
     *
     * @return Products
     */
    public static function getById(\PDO $pdo, int $id): self
    {
        $selectStmt = $pdo->prepare(self::$selectQuery);
        $selectStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $selectStmt->execute([$id]);
        $result = $selectStmt->fetch();

        return (new self($pdo))
            ->setId($id)
            ->setName($result['name'])
            ->setDescription($result['description'])
            ->setCategoryId($result['category_id']);
    }

    /**
     * @param \PDO $pdo
     * @return \DS\Vector
     */
    public static function getList(\PDO $pdo): \DS\Vector
    {
        $selectStmt = $pdo->prepare(self::$selectListQuery);
        $selectStmt->setFetchMode(\PDO::FETCH_OBJ);
        $selectStmt->execute();

        $result = new \DS\Vector();

        while ( $record = $selectStmt->fetch() ) {
            $collectionItem = new self($pdo);

            $collectionItem
                ->setId($record->id)
                ->setName($record->name)
                ->setDescription($record->description)
                ->setCategoryId($record->category_id);

            $result->push($collectionItem);
        }

        return $result;
    }

    /**
     * @return bool
     */
    public function insert(): bool
    {
        $result = $this->insertStmt->execute([
            $this->name,
            $this->description,
            $this->categoryId
        ]);

        $this->id = $this->pdo->lastInsertId();

        return $result;
    }

    /**
     * @return bool
     */
    public function update(): bool
    {
        return $this->updateStmt->execute([
            $this->name,
            $this->description,
            $this->categoryId,
            $this->id
        ]);
    }

    /**
     * @return bool
     */
    public function delete(): bool
    {
        $id = $this->id;
        $this->id = null;

        return $this->deleteStmt->execute([
            $id
        ]);
    }
}
