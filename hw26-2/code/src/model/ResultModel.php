<?php

namespace TimGa\hw26\model;

class ResultModel extends AbstractModel
{

    public function insertResultIntoDb(int $requestId, string $result): void
    {
        $pdo = $this->mysqlDb->connect();
        $sql = 'INSERT INTO result (request_id, result) VALUES(?,?)';
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$requestId, $result]);
    }

    public function selectResultFromDbByRequestId($requestId)
    {
        $pdo = $this->mysqlDb->connect();
        $sql = "SELECT `result` from otus.result WHERE request_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$requestId]);
        $result = $stmt->fetch();
        if ($result) {
            return $result['result'];
        }
        return 'Your request # ' . $requestId . ' is in process, please check later';
    }

}
