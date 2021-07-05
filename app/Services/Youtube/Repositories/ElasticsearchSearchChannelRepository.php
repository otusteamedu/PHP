<?php


namespace App\Services\Youtube\Repositories;


use App\Models\Channel;
use App\Services\Youtube\Repositories\Statistics\ElasticsearchViewChannelRepository;
use App\Services\Youtube\Repositories\Traits\HasElasticsearchQueries;
use Elasticsearch\Client;
use Elasticsearch\Common\Exceptions\Missing404Exception;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class ElasticsearchSearchChannelRepository implements SearchChannelRepository
{
    use HasElasticsearchQueries;

    /**
     * Содержит объект для работы с эластиковй
     * @var Client
     */
    private Client $elasticSearch;

    /**
     * ElasticsearchSearchChannelRepository constructor.
     * @param Client $elasticSearch
     */
    public function __construct(Client $elasticSearch)
    {
        $this->elasticSearch = $elasticSearch;
    }


    public function search(string $q, int $limit, int $offset): Collection
    {
        try {
            $items = $this->searchOnElasticsearch($q, $limit, $offset);
        } catch (Missing404Exception $ex) {
            return collect();
        }
        return $this->buildCollection($items);
    }

    public function getChannelById(int $id): Channel
    {
        $model = new Channel();
        $query = $this->queryGetChannelById($model, $id);
        $result = $this->elasticSearch->search($query);
        return $this->buildChannel($result);
    }

    public function getAllChannelsData(): Collection
    {
        $model = new Channel();
        $query = $this->queryGetAllChannels($model);
        $result = $this->elasticSearch->search($query);
        return $this->buildChannel($result);
    }

    private function searchOnElasticsearch(string $query, int $limit, int $offset): array
    {
        $model = new Channel();
        $query = $this->querySearchChannels($model, $query, $limit, $offset);
        return $this->elasticSearch->search($query);
    }

    /**
     * Возвращает коллекцию каналов
     * Вариант, когда мы создаем запрос в эластику, и получая оттуда id-шники каналов
     * формируем запрос к базе и достаем оттуда уже полную инфу.
     * Этот вариант подходит, когда мы в индекс заносим только те поля, которые необходимы для поиска
     * Или же запрос в эластику сложно реализуем.
     *
     * @param array $items
     * @return Collection
     */
    private function buildCollection(array $items): Collection
    {
        $ids = Arr::pluck($items['hits']['hits'], '_source');
        $ids = array_unique(array_column($ids, "id"));
        return Channel::withSum('videos', 'like_count')
            ->withSum('videos', 'dislike_count')
            ->findMany($ids)
            ->sortBy('id');
    }

    /**
     * Возвращает канал
     * @param array $data
     * @return Channel
     */
    private function buildChannel(array $data): Channel
    {
        if (empty($data['hits']['hits'])) {
            return new Channel();
        }
        $ids = Arr::pluck($data['hits']['hits'], '_source');
        $id = array_unique(array_column($ids, "id"));
        return Channel::find($id)->first();
    }
}
