<?php

declare(strict_types=1);


use MongoDB\Driver\Cursor;

try
{
    require 'vendor/autoload.php';

    $configPath = $_SERVER['DOCUMENT_ROOT'] . '/config.ini';
    $config = parse_ini_file($configPath);

    $mongo = new MongoDB\Client("mongodb://{$config['db_user']}:{$config['db_password']}@mongodb:27017");

    $db = $mongo->youtubedb;
    $channelsCol = $db->selectCollection('channels');

    for ($i = 1; $i <= 3; ++$i) {
        $date = rand(2010, 2020) . '-' . rand(1, 12) . '-' . rand(1, 28) . ' 00:00:00';
        $insertResult = $channelsCol->insertMany([
            [
                'name' => 'Channel 1',
                'url' => "channel_{$i}_url",
                'subscribers' => rand(10, 100000),
                'all_views' => rand(1, 100000),
                'registation_date' => new \DateTime($date)
            ],
        ]);
    }

    /** @var Cursor $channels*/
    $channels = $channelsCol->find([]);
    $videosCol = $db->selectCollection('videos');

    foreach ($channels->toArray() as $channel) {
        for ($i = 1; $i <= 6; ++$i) {
            /** @var \DateTime $create_date */
            $create_date = new \DateTime($channel->registation_date->date);
            $create_date = $create_date->add(new \DateInterval("P{$i}D"));

            $insertResult = $videosCol->insertOne([
                    'name' => "Video {$i}",
                    'url' => "video_{$i}_url",
                    'channel_url' => $channel->url,
                    'create_date' => $create_date,
                    'likes' => rand(10, 10000),
                    'dislikes' => rand(10, 10000),
                    'views' => rand(10, 10000),
                    'description' => "Description {$i}"
                ]);
        }
    }
}
catch (\Throwable $e)
{
   echo $e->getMessage();
}
