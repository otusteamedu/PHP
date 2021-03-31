<?php
require_once 'bootstrap/app.php';

use Src\Models\Post;
use Src\Repositories\Connection\Connection;

$connection = new Connection();
$result = Post::getAll($connection->getPdoSettings());