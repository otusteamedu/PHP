<?php

namespace App\Console\Commands\Search;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Elasticsearch\Client;
use App\Models\Channel;
use App\Models\Video;
use Illuminate\Support\Collection;
use App\Services\Youtube\ChannelService;

class ReindexElasticsearchSeeder extends Command
{
    const INDEX_NAME = 'Название индекса';
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex:elastic';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Index all channels and videos to ElasticSearch';

    /** @var \Elasticsearch\Client */
    private Client $elasticsearch;

    private ChannelService $channelService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $elasticsearch, ChannelService $channelService)
    {
        parent::__construct();
        $this->elasticsearch = $elasticsearch;
        $this->channelService = $channelService;
    }

    /**
     * Execute the console command.
     *
     * @param Client $elasticsearch
     * @return int
     */
    public function handle(Client $elasticsearch): int
    {
        // Можно таким образом создать индекс
        $this->clearIndex();
        return $this->indexingData();

        // А можно и вариантом от Егора
        $this->createIndexWithMapping($elasticsearch);
        $this->indexData($elasticsearch);
    }

    /**
     * Индексирует данные по ютуб каналам в Elasticsearch
     * @return int
     */
    private function indexingData(): int
    {
        $this->info('Indexing all channels. Please wait.');
        $channels = $this->getChannelsData();
        foreach ($channels as $channel) {
            $this->indexingItem($channel);
            $this->output->write('.');
        }
        $this->info(PHP_EOL . 'Indexing is done!');
        return 0;
    }

    /**
     * Очищает индекс полностью
     */
    private function clearIndex()
    {
        $channel = new Channel();
        $this->elasticsearch->deleteByQuery([
            'index'  => $channel->getSearchIndex(),
            'type'   => $channel->getSearchType(),
            'body' => [
                'query' => [
                    'match_all' => (object)[]
                ]
            ],
        ]);
    }

    /**
     * Возвращает сводную таблицу каналов и видео для каналов
     * @return Collection
     */
    private function getChannelsData(): Collection
    {
        return $this->channelService->getAllChannelsData();
    }

    /**
     * Заносит данные в индекс
     * @param $item
     */
    private function indexingItem($item): void
    {
        $item['time'] = (int)(Carbon::createFromTimestamp($item['time'])->subHour()->getTimestamp() . '000');
        $this->elasticsearch->index([
            'index'  => $item->getSearchIndex(),
            'type'   => $item->getSearchType(),
            'id'     => $item->getSearchId(),
            'body'   => $item->toSearchArray()
        ]);
    }

    private function createIndexWithMapping(Client $elasticsearch): void
    {
        $this->createIndex($elasticsearch);
        $this->putMapping($elasticsearch);
    }

    private function createIndex(Client $elasticsearch): void
    {
        try {
            $elasticsearch->indices()->delete([
                'index' => self::INDEX_NAME,
            ]);
        } catch (\Exception $e) {

        }
        $elasticsearch->indices()->create([
            'index' => self::INDEX_NAME,
        ]);
    }

    private function putMapping(Client $elasticsearch): void
    {
        $elasticsearch->indices()->putMapping([
            'index' => self::INDEX_NAME,
            'body' => [
                'properties' => [
                    'time' => [
                        'type' => 'date',
                    ],
                    'id' => [
                        'type' => 'geo_point',
                    ],
                    'youtube_channel_id' => [
                        'type' => 'keyword',
                    ],
                    'channel_title' => [
                        'type' => 'text',
                    ],
                    'channel_description' => [
                        'type' => 'text',
                    ],
                    'video_id' => [
                        'type' => 'integer',
                    ],
                    'published_at' => [
                        'type' => 'date',
                    ],
                    'title' => [
                        'type' => 'text',
                    ],
                    'description' => [
                        'type' => 'text',
                    ],
                    'view_count' => [
                        'type' => 'integer',
                    ],
                    'like_count' => [
                        'type' => 'integer',
                    ],
                    'dislike_count' => [
                        'type' => 'integer',
                    ],
                    'favorite_count' => [
                        'type' => 'integer',
                    ],
                    'comment_count' => [
                        'type' => 'integer',
                    ],
                    'tags' => [
                        'type' => 'text',
                    ],
                ]
            ],
        ]);
    }

    private function indexData(Client $elasticsearch): void
    {
        $data = $this->getData();

        foreach ($data as $datum) {
            $this->indexItem($elasticsearch, $datum);
            $this->output->write('.');
        }
    }

    private function getData(): array
    {
        $data = file_get_contents(__DIR__ . '/data.json');
        return json_decode($data, true);
    }


}
