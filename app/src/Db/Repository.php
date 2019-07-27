<?php

namespace App\Db;

use PDOStatement;

/**
 * Class Repository
 * @package App
 */
class Repository
{
    /**
     * @var Connect
     */
    private $connect;

    /**
     * @var PDOStatement
     */
    private $insertStmt;

    /**
     * @var PDOStatement
     */
    private $selectStmt;

    /**
     * @var PDOStatement
     */
    private $updateStmt;

    /**
     * Repository constructor.
     * @param Connect $connect
     */
    public function __construct(Connect $connect)
    {
        $this->connect = $connect;
        $this->insertStmt = $connect->getPdo()
            ->prepare('INSERT INTO request (question) VALUES (:question)');
        $this->selectStmt = $connect->getPdo()
            ->prepare('SELECT * FROM request WHERE MD5(id::VARCHAR(255)) = :code');
        $this->updateStmt = $connect->getPdo()
            ->prepare("UPDATE request SET status = 1, answer = :answer WHERE MD5(id::VARCHAR(255)) = :code");
    }

    /**
     * @param string $question
     * @return int
     */
    public function insert(string $question): int
    {
        $this->insertStmt->bindParam('question', $question);
        $this->insertStmt->execute();

        return $this->connect->getPdo()->lastInsertId();
    }

    /**
     * @param string $code
     * @return mixed
     */
    public function select(string $code)
    {
        $this->selectStmt->bindParam('code', $code);
        $this->selectStmt->execute();

        return $this->selectStmt->fetch();
    }

    /**
     * @param string $code
     * @param string $answer
     * @return bool
     */
    public function update(string $code, string $answer)
    {
        $this->updateStmt->bindParam('answer', $answer);
        $this->updateStmt->bindParam('code', $code);

        return $this->updateStmt->execute();
    }
}
