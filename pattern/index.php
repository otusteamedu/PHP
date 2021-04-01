<?php
require_once 'bootstrap/app.php';

use Src\Models\Post;
use Src\Repositories\Connection\Connection;

try {
    $connection = new Connection();
    $result = Post::getAll($connection->getPdoSettings());
} catch (PDOException $e) {
    echo $e->getMessage() . PHP_EOL;
}