<?php


namespace Otushw\Storage\Query;

use Otushw\DTOs\QueryDTO;
use Otushw\Models\Query;
use PDO;
use PDOStatement;
use PDOException;
use Otushw\Exception\AppException;

class QueryMapper
{

    private PDO $pdo;
    private PDOStatement $selectStmt;
    private PDOStatement $insertStmt;
    private PDOStatement $updateStmt;
    private PDOStatement $deleteStmt;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
        $this->selectStmt = $pdo->prepare(
            "select id, status from querycm where id = ?"
        );
        $this->insertStmt = $pdo->prepare(
            "insert into querycm (statuscm) values (?)"
        );
        $this->updateStmt = $pdo->prepare(
            "update querycm set statuscm = ? where id = ?"
        );
        $this->deleteStmt = $pdo->prepare("delete from querycm where id = ?");

    }

    public function findById(int $id): ?Query
    {
        try {
            $this->selectStmt->setFetchMode(PDO::FETCH_ASSOC);
            $this->selectStmt->execute([$id]);
            $result = $this->selectStmt->fetch();
        } catch (PDOException $e) {
            throw new AppException($e->getMessage(), $e->getCode());
        }

        if (empty($result)) {
            return null;
        }

        return new Query(
            $id,
            $result['status'],
        );
    }

    public function insert(QueryDTO $query): Query
    {
        try {
            $result = $this->insertStmt->execute([$query->status]);
        } catch (PDOException $e) {
            throw new AppException($e->getMessage(), $e->getCode());
        }

        if (empty($result)) {
            throw new AppException('It is not possible to add a record'
                .  ' (' . $query . ') to table "query"');
        }

        $id = (int) $this->pdo->lastInsertId('querycm_id_seq');
        return new Query(
            (int) $id,
            $query->status,
        );
    }

    public function update(Query $query): bool
    {
        $id = $query->getId();
        try {
            $result = $this->updateStmt->execute([
                $id,
                $query->getStatus(),
                $id
            ]);
        } catch (PDOException $e) {
            throw new AppException($e->getMessage(), $e->getCode());
        }

        return $result;
    }

    public function delete(int $queryID): bool
    {
        try {
            $result = $this->deleteStmt->execute([$queryID]);
        } catch (PDOException $e) {
            throw new AppException($e->getMessage(), $e->getCode());
        }

        return $result;
    }

}