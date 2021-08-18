<?php

function checkAll()
{
    // Адрес сервера на котором запущен сайт
    getServerAddress();
    // Проверка типа запуска скрипта
    checkWhoStarted();
    // Проверка Postgres через PDO
    checkPostgresPDO();
    // Проверка Postgres через pg-connect
    checkPostgres();
    // Проверка Mysql через PDO
    checkMysqlPDO();
    // Проверка Mysql через mysqli
    checkMysqli();
    // Проверка Memprof
    checkMemprof();
    // Проверка Memcached
    checkMemcached();
    // Проверка Elasticsearch
    checkElasticsearch();
    // Проверка Opcache
    checkOpcache();
    // Проверка как был запущен скрипт
    checkWhoStarted();
    // Проверка Redis
    checkRedis();
}

// возвращает адрес сервера, с которого запущен скрипт
function getServerAddress(): string
{
    $tag = 'address';
    showSuccess("Адрес сервера на котором запущен сайт: " . $_SERVER['SERVER_ADDR'], $tag);
    return $_SERVER['SERVER_ADDR'];
}

// возвращает тип запуска скрипта cli, fpm
function checkWhoStarted():string
{
    $tag = 'sapi_name';
    showSuccess(php_sapi_name(), $tag);
    return php_sapi_name();
}

// подключает Postgres через PDO
function checkPostgresPDO(): bool
{
    $tag    = 'postgresPDO';
    $host   = "postgres";
    $port   = "5432";
    $dbname = "postgres";
    $user   = "postgres";
    $pass   = "password";
    $query  = "SELECT current_database ();";
    try {
        $conn = new PDO("pgsql:host=$host; port=$port; dbname=$dbname;", $user, $pass);
        $result = $conn->query($query);
        $row = $result->fetch();
        showSuccess("Postgres connected succesfully. Database: `" . $row[0] . "`", $tag);
        return true;
    } catch (PDOException $pe) {
        showError($pe->getMessage(), $tag);
        echo PHP_EOL;
    }
    return false;
}

// подключает Postgres через pg_connect
function checkPostgres(): bool
{
    $tag    = 'pg_connect';
    $host   = "postgres";
    $port   = "5432";
    $dbname = "postgres";
    $user   = "postgres";
    $pass   = "password";
    $query  = "SELECT current_database ();";
    $conn_string = "host=$host port=$port dbname=$dbname user=$user password=$pass";
    try {
        $conn = pg_connect($conn_string);
        $result = pg_query($conn, $query);
        $row = pg_fetch_row($result);
        showSuccess("Postgres connected successfully. Database: `".$row[0]."`", $tag);
        return true;
    } Catch (Exception $ex) {
        showError(str_ireplace('&quot;', '`', $ex->getMessage()), $tag);
    }
    return false;
}

// подключает MySql через PDO
function checkMysqlPDO():bool
{
    $tag = "mysqlPDO";
    $host = 'db1';
    $dbname = 'laravel';
    $username = 'root';
    $password = 'password';
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        showSuccess("Mysql-master connected BY PDO successfully. Database: `$dbname` at host: `$host`", $tag);
        return true;
    } catch (PDOException $pe) {
        showError($pe->getMessage(), $tag);
        echo PHP_EOL;
    }
    return false;
}

// подключает MySql через mysqli
function checkMysqli():bool
{
    $tag = 'mysqli';
    $serverMySql = "db2";
    $username = "root";
    $password = "password";
    try {
        // Create connection
        $conn = new mysqli($serverMySql, $username, $password);
        showSuccess("Connected to MySql-slave через mysqli - successfully!", $tag);
    } catch (Exception $ex) {
        showError($ex->getMessage(), $tag);
        return false;
    }
    // Check connection - можно и так проверить, если не перехватывать Exception
    if ($conn->connect_error) {
        showError("Connection failed: " . $conn->connect_error, $tag);
    } else {
        showSuccess("Connected to MySql-slave через mysqli - successfully", $tag);
        return true;
    }
    return false;
}

// подключает Redis
function checkRedis(): bool
{
    $tag = 'redis';
    $serverRedis = "redis";
    $key = "test";
    $value = "This is Test value for REDIS";
    try {
        $redis = new Redis();
        $redis->connect($serverRedis, 6379);
        $redis->set($key, $value);
        showSuccess(
            "Connection to server Redis successfully" . PHP_EOL
            . "ping=" .$redis->ping() . PHP_EOL
            . '$redis->set($key, $value);' . PHP_EOL
            . ' - Кладем в ключ: `$key` значение: `$value`' . PHP_EOL
            . '$redis->get($key);' . PHP_EOL
            . '- Берем значение ключа `$key` из редис: ' . $redis->get($key)
            , $tag);
        return true;
    } catch (Exception $ex) {
        showError($ex->getMessage(), $tag);
    }
    return false;
}

// Выводит информацию о Redis
function getRedisInfo(): void
{
    $tag = 'redis';
    $serverRedis = "redis";
    try {
        $redis = new Redis();
        $redis->connect($serverRedis, 6379);
        showSuccess($redis->info(), $tag);
    } catch (Exception $ex) {
        showError($ex->getMessage(), $tag);
    }
}

// проверяет Memprof
function checkMemprof(): bool
{
    $tag = 'memprof';
    $path = $_SERVER['MEMPROF_LOG_PATH'] ?? "/var/log/";
    $fileName = $path . "memprof_logs.out";
    $state = false;
    try {
        if (function_exists('memprof_enable')) {
            memprof_enable();
            $state = true;
        } else {
            showError("Memprof - не был включен!", $tag);
            return $state;
        }
    } catch (Exception $ex) {
        ($ex->getCode() === 0)
            ? showSuccess($ex->getMessage().PHP_EOL."Информация по использованию памяти в файле $fileName", $state = $tag)
            : showError($ex->getMessage(), $tag);
    }
    memprof_dump_callgrind(fopen($fileName, "w"));
    memprof_disable();
    return $state;
}

// подключает Elasticsearch
function checkElasticsearch(): bool
{
    $tag = 'elastic';
    try {
        //$client = Elasticsearch\ClientBuilder::create()->build();
        $client = getElasticsearchClient();
        if ($client) {
            showSuccess("ElasticSearch-php is enabled", "elastic-php");
        }
        try {
            showSuccess($client->info(), $tag);
        } catch (\Exception $ex) {
            showError($ex->getMessage(), $tag);
        }
        return true;
    } catch (\Exception $ex) {
        echo $ex->getMessage();
    }
    return false;
}

// подключает Memcached
function checkMemcached(): bool
{
    $tag = 'memcached';
    $memcached = new Memcached;
    $servers = array(
        array('memcached-2', 11211, 50),
        array('memcached-1', 11211, 50),
    );
    // устанавливаются опции для кластера memcached если их нет в php.ini
    $memcached->setOption(Memcached::OPT_CONNECT_TIMEOUT, 1);
    $memcached->setOption(Memcached::OPT_DISTRIBUTION, Memcached::DISTRIBUTION_CONSISTENT);
    $memcached->setOption(Memcached::OPT_SERVER_FAILURE_LIMIT, 1);
    $memcached->setOption(Memcached::OPT_REMOVE_FAILED_SERVERS, true);
    $memcached->setOption(Memcached::OPT_RETRY_TIMEOUT, 1);

    $memcached->addServers($servers);
    // если один из серверов лежит, то getVersion будет некоторое время ждать connection и вернет false
    $versions = $memcached->getVersion();
    $servers = array_merge($servers, (array)$versions);

    // Почему-то, при выключенном сервере $connection все равно true
    // и при try-catch, тоже не выводит ошибку подключения.
    // Приходится идти путем: положил, взял, сравнил.
    $key = "key";
    $value = "This is Test value for MemCached";
    $memcached->set($key, $value);
    $get_value = $memcached->get($key);
    if ($value == $get_value) {
        showSuccess("Connection to server " . print_r($servers, true) . " SUCCESSED!", $tag);
        return true;
    } else {
        showError("Connection to server " . print_r($servers, true) . " FAILED!", $tag);
    }
    return false;
}

// функция проверки статуса opcache
function checkOpcache()
{
    $tag = "opcache";
    $opcacheStatus = opcache_get_status();
    ($opcacheStatus['opcache_enabled'] === true)
        ? showSuccess($opcacheStatus['opcache_enabled'], $tag)
        : showError($opcacheStatus['opcache_enabled'], $tag);
}

function getOpcacheInfo()
{
    $tag = "opcache";
    $opcacheStatus = opcache_get_status();
    ($opcacheStatus['opcache_enabled'] === true)
        ? showSuccess($opcacheStatus, $tag)
        : showError($opcacheStatus, $tag);
}

// возвращает соединение с Elasticsearch
function getElasticsearchClient(): \Elasticsearch\Client
{
    $hosts = [
        //'192.168.1.1:9200',         // IP + Port
        //'192.168.1.2',              // Just IP
        'elasticsearch:9200', // Domain + Port
        //'mydomain2.server.com',     // Just Domain
        //'https://localhost',        // SSL to localhost
        //'https://192.168.1.3:9200'  // SSL to IP + Port
    ];
    return Elasticsearch\ClientBuilder::create()           // Instantiate a new ClientBuilder
    ->setHosts($hosts)      // Set the hosts
    ->build();
}

// выводит сообщение красным цветом
function showError($msg, string $destinationTagId): void
{
    showMessage($msg, $destinationTagId, 'red');
}

// выводит сообщение зелёным цветом
function showSuccess($msg, string $destinationTagId): void
{
    showMessage($msg, $destinationTagId, 'green');
}

// выводит сообщение c заданным цветом
function showMessage($msg, string $destinationTagId, $color): void
{
    echo "<script>
            var message = " . json_encode($msg) . ";
            var tag = document.getElementById('". $destinationTagId ."')
            if (tag === null) die();
            tag.style.color='" . $color . "';
            (typeof message === 'object') 
                ? tag.innerText = JSON.stringify(message, null, 4)
                //tag.innerText = print_r(message);
                : tag.innerText = message;
          </script>";
}

// pg_connect, mysqli, memprof не бросают исключений поэтому нужно отловить ошибку и создать исключение самостоятельно
function exception_error_handler($errno, $errstr, $errfile, $errline) {
    throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
}
set_error_handler("exception_error_handler");