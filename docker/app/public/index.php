<?php

try {
    $mc = new Memcached();
    $mc->addServer("memcached", 11211);

    $redis = new Redis();
    $redis->connect('redis');

} catch (\Throwable $e) {
    echo $e->getMessage();
}
