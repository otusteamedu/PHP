<?php

declare(strict_types=1);

namespace tests;

use app\{Channel, Video, Stats};
use app\Channel\Collection;
use app\Channel\Mapper;
use app\Storage\MongoDb;
use PHPUnit\Framework\TestCase;

class ChannelTest extends TestCase
{
    /**
     * @var Collection
     */
    private $channelCollection;

    /**
     * @var Mapper
     */
    private $mapper;

    /**
     * @var MongoDb
     */
    private $mongodb;

    /**
     * @var array
     */
    private $config;

    public function setUp(): void
    {
        parent::setUp();

        $config = require __DIR__ . '/../../config/test.php';
        $this->config = $config;
        $this->mongodb = new MongoDb($config['mongodb']);
        $this->mapper = new Mapper($this->mongodb);

        $this->channelCollection = new Collection();

        for ($i = 3; $i < 15; $i++) {
            $this->channelCollection->addChannel($this->getRandomChannel(rand(20, 50)));
        }

        foreach ($this->channelCollection->getChannels() as $channel) {
            $this->mapper->insertChannel($channel);
        }
    }

    private function getRandomChannel(int $videosCount = 3): Channel
    {
        $channel = new \app\Channel();
        $channelId = uniqid('channel_');
        $channel->setId($channelId);
        $channel->setTitle($channelId);

        for ($i = 0; $i < $videosCount; $i++) {
            $videoId = uniqid('video_');
            $channel->addVideo(new Video([
                'id' => $videoId,
                'title' => $videoId,
                'duration' => rand(100, 10000),
                'stats' => new Stats(
                    rand(0, 50000), //likes
                    rand(0, 50000), //dislikes
                    rand(0, 5000), //comments
                    rand(50000, 100000) //views
                ),
                'publishedAt' => '2016-07-05T11:11:20.000Z'
            ]));
        }

        return $channel;
    }

    public function tearDown(): void
    {
        parent::tearDown();
        $this->mongodb->getClient()->dropDatabase($this->config['mongodb']['db']);
    }

    public function testChannelCollection(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->channelCollection->addChannels(['bad one']);
    }

    public function testChannelRate(): void
    {
        $channel = current($this->channelCollection->getChannels());
        $stats = $this->mapper->getChannelStats($channel->getId());

        $calculatedStats = (new Channel\StatsCalculator($channel))->calculate();

        $this->assertEquals($calculatedStats->likes, $stats->likes);
        $this->assertEquals($calculatedStats->dislikes, $stats->dislikes);
    }

    public function testTopChannels(): void
    {
        $limit = 3;
        $channels = $this->mapper->getTopChannels($limit)->getChannels();

        $calculatedStats = [];
        foreach ($this->channelCollection->getChannels() as $channel) {
            $stats = (new Channel\StatsCalculator($channel))->calculate();
            $calculatedStats[$channel->getId()] = $stats->likes ? ($stats->dislikes / $stats->likes) : 0;
        }

        uasort($calculatedStats, function ($a, $b) {
            if ($a > $b) {
                return -1;
            } elseif ($a < $b) {
                return 1;
            }

            return 0;
        });

        $this->assertEquals(current($channels)->getId(), key($calculatedStats));
    }
}
