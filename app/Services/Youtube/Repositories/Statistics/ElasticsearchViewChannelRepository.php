<?php


namespace App\Services\Youtube\Repositories\Statistics;


use App\Models\Channel;
use App\Services\Youtube\ChannelService;
use App\Services\Youtube\Repositories\Traits\HasElasticsearchQueries;
use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\BadRequest400Exception;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ElasticsearchViewChannelRepository implements ViewChannelRepository
{
    use HasElasticsearchQueries;

    /**
     * @var Client
     */
    private Client $elasticSearch;

    /**
     * @var Channel
     */
    private Channel $channel;

    /**
     * ElasticsearchViewChannelRepository constructor.
     * @param Client $elasticSearch
     */
    public function __construct(Client $elasticSearch)
    {
        $this->channel = new Channel();
        $this->elasticSearch = $elasticSearch;
    }

    public function getViewsCount(int $channelId): int
    {
        $query = $this->queryGetChannelStatistic($this->channel, $channelId);
        $items = $this->elasticSearch->search($query);
        return (int)$this->buildCollection($items)[0]->getAttribute('view_count');
    }

    public function getCommentsCount(int $channelId): int
    {
        $query = $this->queryGetChannelStatistic($this->channel, $channelId);
        $items = $this->elasticSearch->search($query);
        return (int)$this->buildCollection($items)[0]->getAttribute('comment_count');
    }

    public function getLikesCount(int $channelId): int
    {
        $query = $this->queryGetChannelStatistic($this->channel, $channelId);
        $items = $this->elasticSearch->search($query);
        return (int)$this->buildCollection($items)[0]->getAttribute('videos_sum_like_count');
    }

    public function getDislikesCount(int $channelId): int
    {
        $query = $this->queryGetChannelStatistic($this->channel, $channelId);
        $items = $this->elasticSearch->search($query);
        return (int)$this->buildCollection($items)[0]->getAttribute('videos_sum_dislike_count');
    }

    /**
     * Достает и возвращает коллекцию Топ $number каналов из ElasticSearch
     * Условие для попадания в топ - сумаа по всем видео с лучшим соотношением Likes/Dislikes для каждого видео
     * @param int $number
     * @return Collection
     */
    public function getTopChannels(int $number): Collection
    {
        $query = $this->queryGetTopChannels($this->channel, $number);
        try {
            $items = $this->elasticSearch->search($query);
        } catch (BadRequest400Exception $ex) {
            dd($ex->getMessage());
        }

        return $this->buildCollection($items);

        $query = $this->queryGetTopChannels($number);
        try {
            $items = $this->elasticSearch->sql()->query(['body' => 'Select * from '.$this->channel->getSearchIndex()]); // ->search($query);
        } catch (BadRequest400Exception $ex) {
            dd($ex->getMessage());
        }

        return $this->buildCollection($items);
    }

    /**
     * Возвращает коллекцию каналов на основе $items
     * @param array $items
     * @return Collection
     */
    private function buildCollection(array $items): Collection
    {
        $channels = [];
        foreach ($items['aggregations']['top_channels']['buckets'] as $chanellElasticsearchData) {
            $channelFromElasticSearch = $chanellElasticsearchData['channel']['hits']['hits'][0]['_source'];
            $channel = isset($channelFromElasticSearch)
                ? new Channel($channelFromElasticSearch)
                : new Channel();
            $channel['id'] = $chanellElasticsearchData['key'];
            $channel['title'] = $channelFromElasticSearch['channel_title'] ?? $channelFromElasticSearch['title'];
            $channel['description'] = $channelFromElasticSearch['channel_description'] ?? $channelFromElasticSearch['description'];
            $channel['videos_sum_like_count'] = $chanellElasticsearchData['total_number_likes']['value'] ?? 0;
            $channel['videos_sum_dislike_count'] = $chanellElasticsearchData['total_number_dislikes']['value'] ?? 0;
            $channel['view_count'] = $chanellElasticsearchData['total_number_views']['value'] ?? 0;
            $channel['comment_count'] = $chanellElasticsearchData['total_number_comments']['value'] ?? 0;
            $channels[] = $channel;
        }
        return collect($channels);
    }


}
