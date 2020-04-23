<?php

require_once __DIR__. '/vendor/autoload.php';

$mc = new Memcached();
$mc->addServer("mymemcached", 11211);
$mc->add("key1", "value1");
$mc->add("key2", "value2");
$mc->add("key3", "value3");

echo "key1 : " . $mc->get("key1") . "\n";
echo "key2 : " . $mc->get("key2") . "\n";
echo "key3 : " . $mc->get("key3") . "\n";
