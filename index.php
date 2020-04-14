#!/usr/bin/env php
<?php

namespace App\Console;

use Symfony\Component\Console\Application;

chdir(__DIR__);
require_once __DIR__ . '/vendor/autoload.php';

$application = new Application();

$application->add(new SearchAndFill());
$application->add(new AddIndex());
$application->add(new Top());
$application->add(new ChannelLikes());

/** @noinspection PhpUnhandledExceptionInspection */
$application->run();
