<?php


namespace App\Repositories;


use Otus\DBConnection;
use \PDO;

abstract class BaseRepository
{
    protected DBConnection $pdo;
    /**
     * @var bool|PDOStatement
     */
    protected $selectStmt;

    /**
     * @var bool|PDOStatement
     */
    protected $insertStmt;

    /**
     * @var bool|PDOStatement
     */
    protected $updateStmt;

    /**
     * @var bool|PDOStatement
     */
    protected $deleteStmt;

    /**
     * @var bool|PDOStatement
     */
    protected $lastInsertIdStmt;

    /**
     * @return int
     */
    protected function getLasInsertedId()
    {
        $this->lastInsertIdStmt->setFetchMode(PDO::FETCH_ASSOC);
        $this->lastInsertIdStmt->execute();
        $result = $this->lastInsertIdStmt->fetch();
        return (int)$result['last_value'];
    }
}
