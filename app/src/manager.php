<?php

use App\Connect;

include_once __DIR__ . '/../vendor/autoload.php';

$dbType = 'pgsql';
$host = 'otus-postgres';
$dbName = 'cinema';
$user = 'cinema';
$password = '1231';

if (!empty($argv[1])) {
    try {
        $connect = new Connect($dbType, $host, $dbName, $user, $password);
        $stmt = $connect->getPdo()->prepare("UPDATE request SET status = 1, answer = 'Ответ' WHERE MD5(id::VARCHAR(255)) = ?");
        $stmt->execute([$argv[1]]);
    } catch (\Exception $exception) {
        echo $exception->getMessage();
    }
}
