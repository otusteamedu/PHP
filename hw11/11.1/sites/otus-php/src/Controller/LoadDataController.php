<?php

declare(strict_types=1);

namespace App\Controller;

use App\Kernel\Application;
use App\Kernel\Response;
use MongoDB\Collection;
use MongoDB\Driver\Cursor;

class LoadDataController
{
    /**
     * @var Application
     */
    private $app;

    /**
     * @var object
     */
    private $db;

    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->db = $app->getDb();
    }

    /**
     * @throws \Exception
     */
    public function handler()
    {
        /** @var Collection $channelsCol */
        $channelsCol = $this->db->selectCollection('channels');

        for ($i = 1; $i <= 3; ++$i) {
            $date = rand(2010, 2020) . '-' . rand(1, 12) . '-' . rand(1, 28) . ' 00:00:00';
            $insertResult = $channelsCol->insertOne(
                [
                    'name' => "Channel {$i}",
                    'url' => "channel_{$i}_url",
                    'subscribers' => rand(10, 100000),
                    'all_views' => rand(1, 100000),
                    'registration_date' => new \DateTime($date)
                ],
            );

            if ($insertResult->getInsertedCount() < 1) {
                throw new \Exception('Во время загрузки данных возникла ошибка');
            }
        }

        /** @var Cursor $channels*/
        $channels = $channelsCol->find([]);
        /** @var Collection $videosCol */
        $videosCol = $this->db->selectCollection('videos');

        foreach ($channels->toArray() as $channel) {
            for ($i = 1; $i <= 6; ++$i) {
                /** @var \DateTime $create_date */
                $create_date = new \DateTime($channel->registration_date->date);
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

                if ($insertResult->getInsertedCount() < 1) {
                    throw new \Exception('Во время загрузки данных возникла ошибка');
                }
            }
        }

        return new Response(['success' => "Данные загружены"]);
    }
}



