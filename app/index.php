<?php
require __DIR__ . '/vendor/autoload.php';

if (($config = parse_ini_file(__DIR__ . "/config.ini")) === false)
    die('Cant parse config file =<');

$short_opts = "t:p::h";
$long_opts = [
    "type:",
    "path::",
    "help"
];
$options = getopt($short_opts, $long_opts);

$help = isset($options['h']) || isset($options['help']);
if ($help) {
    $msg = "Specify the type of socket you want to initialize with -t (--type) option." . PHP_EOL .
        "Type should be `server` or `client` " . PHP_EOL .
        "You can change socket path with -p (--path) option (optional)." . PHP_EOL .
        "It would use default path from config.ini if not specified -p(--path) option. " . PHP_EOL;
    exit($msg);
}

$type = $options['t'] ?? ($options['type'] ?? false);
if (!$type)
    exit('You should point to the type of socket you want to initialize. Use -t(--type) option.' . PHP_EOL);
if (!in_array($type, ['client', 'server']))
    exit('Type should be `client` or `server`.' . PHP_EOL);

$path = $options['p'] ?? ($options['path'] ?? $config['socket_path']);

try {
    $socket_class = "models\\Socket" . ucfirst($type);
    /** @var models\SocketClient|models\SocketServer $socket */
    $socket = new $socket_class(
        $path,
        intval($config['socket_domain']),
        intval($config['socket_type']),
        intval($config['socket_read_length'])
    );
    $socket->run();
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}
