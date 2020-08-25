<?php

require_once __DIR__ . '/vendor/autoload.php';

$shortOpts = "t:m:";
$longOpts = ["type:", "message:"];
$options = getopt($shortOpts, $longOpts);
$type = $options['t'] ?? $options['type'];
$message = $options['m'] ?? $options['message'];
try {
    if (empty($type)) {
        throw new Exception(
            'You must specify the type via the t parameter or the type. Valid values are client or server'.PHP_EOL
        );
    }
    if ($type !== 'server' && $type !== 'client') {
        throw new Exception('Valid values for client or server type'.PHP_EOL);
    }

    if ($type === 'client' && empty($message)) {
        $pool = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ ';
        $message = substr(str_shuffle(str_repeat($pool, 5)), 0, 100);
    }


    $class = "App\\" . ucfirst($type);

    (new $class(__DIR__ . '/conf.ini'))->start($type !== 'client' ?: $message);
} catch (Exception $exception) {
    echo $exception->getMessage();
    exit();
}
