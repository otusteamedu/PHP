<?php

namespace TimGa\hw26\model;

class RequestModel extends AbstractModel
{

    public function insertUserRequestIntoDb(int $userInputValue): int
    {
        $pdo = $this->mysqlDb->connect();
        $sql = 'INSERT INTO request (user_input_value) VALUES(?)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$userInputValue]);
        return $pdo->lastInsertId();
    }

    public function requestExists(int $requestId): bool
    {
        $pdo = $this->mysqlDb->connect();
        $sql = 'SELECT count(1) FROM request WHERE request_id = ?';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$requestId]);
        $result = $stmt->fetchColumn();
        return ($result == 1);
    }

}
