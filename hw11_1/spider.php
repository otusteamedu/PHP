<?php

declare(strict_types=1);

use App\Contracts\IO\Output;
use App\Contracts\Storage;
use App\Services\YouTubeSpider;

$container = require dirname(__FILE__) . '/config/container.php';

/** @var YouTubeSpider $spider */
$spider = $container[YouTubeSpider::class];
/** @var Storage $storage */
$storage = $container[Storage::class];
/** @var Output $output */
$output = $container[Output::class];

$category = $spider->selectCategory('RU');

if ($category === null) {
    exit();
}

$output->writeLn('Saving the channels to storage, please wait...');

$spider->saveCategoryChannels($category, $container[Storage::class]);

$output->writeLn('Done.');
