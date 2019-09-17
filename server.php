<?php

require __DIR__ . '/vendor/autoload.php';

use App\StdIn;
use App\StdOut;
use App\UnixSocket;
use App\Server;

$socketFile = getenv('SOCKET_FILE');

$transport = (new UnixSocket($socketFile));

$input = (new StdIn());
$output = (new StdOut());

(new Server($input, $output, $transport, 'server'))->init();
