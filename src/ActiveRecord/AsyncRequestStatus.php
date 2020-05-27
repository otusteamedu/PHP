<?php
namespace Otus\ActiveRecord;

class AsyncRequestStatus
{
    private const TABLE_NAME = 'async_request_status';

    /**
     * @var \PDO
     */
    private $pdo;

    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     * values: 0 - free, 1 - in process, 2 - success, 3 - error
     */
    private $status;

    /**
     * @var \PDOStatement
     */
    private static $selectQuery = "select id, status from " . self::TABLE_NAME . " where id = ?";

    /**
     * @var \PDOStatement
     */
    private static $selectListQuery = "select * from " . self::TABLE_NAME . " limit 10";

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
            "insert into " . self::TABLE_NAME . " (status) values (?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update " . self::TABLE_NAME . " set status = ? where id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from " . self::TABLE_NAME . " where id = ?");
    }

    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return int|null
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int $status
     * @return $this
     */
    public function setStatus(int $status): self
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @param \PDO $pdo
     * @param int $id
     * @return static
     */
    public static function getById(\PDO $pdo, int $id): self
    {
        $selectStmt = $pdo->prepare(self::$selectQuery);
        $selectStmt->setFetchMode(\PDO::FETCH_OBJ);
        $selectStmt->execute([$id]);
        $result = $selectStmt->fetch();

        $row = new self($pdo);
        $row->setId($id);

        if ($result !== false) {
            $row->setStatus($result->status);
        }

        return $row;
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

        while ($record = $selectStmt->fetch()) {
            $collectionItem = new self($pdo);

            $collectionItem
                ->setId($record->id)
                ->setStatus($record->status);

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
            $this->status
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
            $this->status,
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
