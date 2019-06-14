<?php

try {
    $dbname = getenv('DB_NAME');
    $dbuser = getenv('DB_USER');
    $dbpass = getenv('DB_PASSWORD');
    $db = new PDO("pgsql:host=db;dbname=".$dbname.";user=".$dbuser.";password=".$dbpass);
    echo 'DB connection success<br/>';
} catch (PDOException $e) {
    echo 'DB connection error:' .$e->getMessage().'<br/>';
}

$memcache = new Memcached();
$memcache->addServer('memcached', 11211);
if ($memcache->getStats()) {
    echo 'Memcache connection success<br/>';
} else {
    echo 'Memcache connection error<br/>';
}

$redis = new Redis();

if ($redis->connect('redis', 6379)) {
    echo 'Redis connection success<br/>';
} else {
    echo 'Redis connection error:' .$e->getMessage().'<br/>';
}
