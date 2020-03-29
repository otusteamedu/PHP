<?php declare(strict_types=1);

require __DIR__.'/../vendor/autoload.php';

$appSubscriber = new AppSubscriber();
$appSubscriber->run($argv);
