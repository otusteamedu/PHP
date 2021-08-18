<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

echo "<pre>";
echo "Сайт OTUS.LOC из контейнера" . PHP_EOL;
echo "Адрес сервера на котором запущен сайт: ";
echo $_SERVER['SERVER_ADDR'] . PHP_EOL;
die();

// функция проверки статуса opcache
var_dump(opcache_get_status());
echo "Формат запуска скрипта: ";
echo php_sapi_name() . PHP_EOL;

// названия серверов из Docker-compose.yml
$serverRedis        = "redis";
$serverMemcached    = "memcached";
$serverMySql        = "db";

// подключамся к Redis
echo "Подключаемся к Redis..." . PHP_EOL;
$key = "test";
$value = "This is Test value for REDIS";
try {
    $redis = new Redis();
    $redis->connect($serverRedis, 6379);
    echo "Connection to server Redis successfully" . PHP_EOL;
    echo "Кладем в ключ: '$key' значение: '$value'" . PHP_EOL;
    $redis->set($key, $value);
    echo "Server '$serverRedis' is running: " . $redis->ping() . ", " . $redis->get($key) . PHP_EOL;
} catch (Exception $ex) {
    echo "Connection to server Redis FAILED" . PHP_EOL;
    echo $ex->getMessage() . PHP_EOL;
}

// подключаемся к Memcached
echo PHP_EOL . "Создаем объект Memcached и добавляем сервер с хостом memcached и портом 11211..." . PHP_EOL;
$memcache = new Memcached;
$memcache->addServer($serverMemcached, 11211);
$key = "key";
$value = "This is Test value for MemCached";
echo "Кладем в ключ: '$key' значение: '$value'" . PHP_EOL;
$memcache->set($key, $value);
$get_value = $memcache->get($key);
echo "Данные из Memcache: $get_value" .PHP_EOL;
if ($value == $get_value) {
    echo "Connection to server '$serverMemcached' SUCCESSED!" . PHP_EOL;
} else {
    echo "Connection to server '$serverMemcached' FAILED!" . PHP_EOL;
}

// подключаемся к MySql
$serverMySql = "db1";
$username = "root";
$password = "password";

// Create connection
echo PHP_EOL . "Подключаемся к MySQL..." . PHP_EOL;
$conn = new mysqli($serverMySql, $username, $password);

// Check connection
if ($conn->connect_error) {
    echo ("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected to MySql через mysqli - successfully" . PHP_EOL;
}

echo PHP_EOL . "Попытка подключиться к MYSQL через PDO" . PHP_EOL;
$host = 'db1';
$dbname = 'laravel';
$username = 'root';
$password = 'password';
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    echo "Connected to database: '$dbname' at host: '$host' BY PDO successfully." . PHP_EOL;
} catch (PDOException $pe) {
    echo "Could not connect to the database $dbname :" . $pe->getMessage() . PHP_EOL;
}

// подключаемся к POSTGRES
echo PHP_EOL . "Подключаемся к POSTGRES" .PHP_EOL;
$host   = "postgres";
$port   = "5432";
$dbname = "postgres";
$user   = "postgres";
$pass   = "password";
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$pass";
$dbconn = pg_connect($conn_string);

echo "Postgres = $dbconn" . PHP_EOL;

$r = [1,2,3,4,5];
echo PHP_EOL . "выведем статус сборщика мусора\n";
gc_collect_cycles();
var_dump(gc_status());
echo "что там в переменной r? \n";
xdebug_debug_zval('r');
unset($r);
echo "show r after unset: ";
xdebug_debug_zval('r');
phpinfo(8);
