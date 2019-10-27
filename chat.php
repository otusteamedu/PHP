<?php

require __DIR__ . '/vendor/autoload.php';

use App\UnixSocket;
use App\StdIn;
use App\StdOut;
use App\Client;

$socketFile = getenv('SOCKET_FILE');

$transport = (new UnixSocket($socketFile));
$input = (new StdIn());
$output = (new StdOut());

(new Client($input, $output, $transport, 'client'))->init();
