<?php
require_once __DIR__ . '/checker.php';
require_once __DIR__ . '/checker.html';
require_once __DIR__ . '/vendor/autoload.php';

ini_set('error_reporting', E_ALL);
ini_set('display_errors', 0);
ini_set('display_startup_errors', 1);

echo "<pre>";

$result = $_POST['checker'] ?? "all";
switch ($result) {
    case "address":
        getServerAddress();
        break;
    case "sapi_name":
        checkWhoStarted();
        break;
    case "postgresPDO":
        checkPostgresPDO();
        break;
    case "pg_connect":
        checkPostgres();
        break;
    case "mysqlPDO":
        checkMysqlPDO();
        break;
    case "mysqli":
        checkMysqli();
        break;
    case "redis":
        getRedisInfo();
        break;
    case "memcached":
        checkMemcached();
        break;
    case "elastic":
        checkElasticsearch();
        break;
    case "memprof":
        checkMemprof();
        break;
    case "opcache":
        getOpcacheInfo();
        break;
    case "checkAll":
        checkAll();
        break;
}

phpinfo();
