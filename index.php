<?php

include_once('vendor/autoload.php');

use App\Ini;
use App\Server;
use App\Client;
use App\ConsoleLog;
use App\TextLog;

//Читаем параметры
$shotOptions = 'hi::l::ots::ce::m::';
$longOptions = [
    'help',
    'ini::',
    'log::',
    'console',
    'socket::',
    'client',
    'clsocket::',
    'message::'
];
$options = getopt($shotOptions, $longOptions);

//Экран помощи
$help = (isset($options['h'])) || (isset($options['help']));
if ($help) {

    echo PHP_EOL . PHP_EOL . 'Домашнеее задание к уроку №5 \'PHP in CLI\'';
    echo 'курса с otus.ru по специальности \'PHP-разработчик\'' . PHP_EOL . PHP_EOL;

    echo 'Параметры которые передаються в программу:' . PHP_EOL;

    echo '-h, -help     - вывод экрана с описание параметров (текущее окно)' . PHP_EOL;
    echo '-i, -ini      - путь к файлу с настройками, если не указан, то ищется в текущей папке config.ini' . PHP_EOL;
    echo '-l, -log      - путь к файлу, куда дописывается информация о работе программы, ';
    echo 'если не указан, то берется параметр \'logFile\' из файла настроек' . PHP_EOL;
    echo '-o, -console, вывод всей информации в консоль, -l, -log игнорируется' . PHP_EOL;
    echo '-s, -socket   - путь к сокету сервера, если не указан,';
    echo 'то берется параметр \'serversocket\' из файла настроек' . PHP_EOL;
    echo '-c, -client   - если указан, то программа работает в режиме клиента' . PHP_EOL;
    echo '-e, -clsocket - путь к сокету клиента, если не указан,';
    echo 'то берется параметр \'clientsocket\' из файла настроек' . PHP_EOL;
    echo '-m, -message  - сообщение передаваемое серверу, работает с флагом \'c\', если не указано, ';
    echo 'то передается \'тестовое сообщение\'' . PHP_EOL . PHP_EOL;

    exit();
}

//Файл с настройками
$iniFile = $options['i'] ?? ($options['ini'] ?? __DIR__ . '/config.ini');
$ini = new Ini($iniFile);

//Настройки клиента
$client = (isset($options['c'])) || (isset($options['client']));
$clientSocket = $options['e'] ?? ($options['clsocket'] ?? $ini->getParam('clientsocket'));

//Логи
if ((isset($options['o'])) || (isset($options['console']))) {
    $log = new ConsoleLog();
} else {
    $logFile = $options['l'] ?? ($options['log'] ?? $ini->getParam('logfile'));
    $log = new TextLog($logFile, $client ? 'CLIENT' : 'SERVER');
}
//Путь к сокету сервера
$socketDir = $options['s'] ?? $options['socket'] ?? $ini->getParam('serversocket');

//Собщение для сервера
$msg = $options['m'] ?? $options['message'] ?? 'тестовое сообщение';

try {
    if ($client)
        $client = new Client($socketDir, $clientSocket, $msg, $log);
    else
        $server = new Server($socketDir, $log);
} catch (Exception $exception) {
    $log->ERROR($exception->getMessage());
}

$log->closeLog();

