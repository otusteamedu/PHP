<?php

namespace Src\Patterns\ActiveRecord;

use Src\Patterns\Collection;

/**
 * Class Employee
 *
 * @package Src\Patterns\ActiveRecord
 */
class Employee
{
    /**
     * @var \PDO
     */
    private $pdo;

    private $id;

    private $name;

    private $position;

    private $start_work_date;

    /**
     * @var \PDOStatement
     */
    private static $selectQuery = "select name, position, start_work_date from employee where id = ?";

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
     * @var \PDOStatement
     */
    private \PDOStatement $getRecordsStmt;

    /**
     * @param \PDO $pdo
     */
    public function __construct(\PDO $pdo)
    {
        $this->pdo = $pdo;

        $this->setStmtInsert();
        $this->setStmtUpdate();
        $this->setStmtDelete();

        $this->getRecordsStmt = $pdo->prepare('select name, position, start_work_date from employee order by id limit :limit offset :offset');
    }

    private static function getTableName()
    {
        return 'employee';
    }


    private static function getFieldsNames()
    {
        return ['name', 'position', 'start_work_date'];
    }

    private function setStmtInsert()
    {
        $table = static::getTableName();
        $fields = static::getFieldsNames();
        $values = array_fill(0, count($fields), '?');

        $fields = implode(',', $fields);
        $values = implode(',', $values);

        $query = "insert into $table ($fields) values ($values)";
        $this->insertStmt = $this->pdo->prepare($query);
    }

    private function setStmtUpdate()
    {
        $table = static::getTableName();

        foreach (static::getFieldsNames() as $field) {
            $set[] = "$field = ?";
        }
        $set = implode(', ', $set);

        $query = "update $table set $set where id = ?";
        $this->updateStmt = $this->pdo->prepare($query);
    }

    private function setStmtDelete()
    {
        $table = static::getTableName();
        $this->deleteStmt = $this->pdo->prepare("delete from $table where id = ?");
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
     */
    public function setId(int $id): void
    {
        $this->id = $id;
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
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        return $this->position;
    }

    /**
     * @param string $position
     */
    public function setPosition(string $position): void
    {
        $this->position = $position;
    }

    /**
     * @return mixed
     */
    public function getStartWorkDate()
    {
        return $this->start_work_date;
    }

    /**
     * @param mixed $start_work_date
     */
    public function setStartWorkDate($start_work_date): void
    {
        $this->start_work_date = $start_work_date;
    }

    /**
     * @param \PDO $pdo
     * @param int $id
     *
     * @return Employee
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
            ->setPosition($result['position'])
            ->setStartWorkDate($result['start_work_date']);
    }

    /**
     * @return bool
     */
    public function insert(): bool
    {
        $result = $this->insertStmt->execute([
            $this->name,
            $this->position,
            $this->start_work_date
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
            $this->position,
            $this->start_work_date,
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
        return $this->deleteStmt->execute([$id]);
    }

    public function getRecords(int $limit, int $offset): ?Collection
    {
        $this->getRecordsStmt->setFetchMode(\PDO::FETCH_ASSOC);
        $this->getRecordsStmt->bindParam('limit', $limit, \PDO::PARAM_INT);
        $this->getRecordsStmt->bindParam('offset', $offset, \PDO::PARAM_INT);
        $this->getRecordsStmt->execute();

        $result = $this->getRecordsStmt->fetchAll();

        if (empty($result)) {
            return null;
        }

        return new Collection($result);
    }
}