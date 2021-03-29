<?php

namespace App\Repositories\Channel;

use App\Entities\BaseEntity;
use App\Entities\Channel;
use App\Repositories\BaseElasticSearchRepository;
use App\Repositories\Video\ElasticSearchVideoRepository;
use Illuminate\Support\Collection;


class ElasticSearchChannelRepository extends BaseElasticSearchRepository implements ChannelRepository
{
    protected const INDEX = 'channels';

    private bool $withVideos = false;
    private bool $withVideoStatistics = false;

    private ElasticSearchVideoRepository $videoRepository;

    public function __construct()
    {
        $this->videoRepository = new ElasticSearchVideoRepository();
        parent::__construct();
    }

    /**
     * @return Collection|Channel[]
     */
    public function getAll(): Collection
    {
        return parent::getAll();
    }

    /**
     * @param string $id
     * @return Channel
     */
    public function getById(string $id): Channel
    {
        return parent::getById($id);
    }

    /**
     * @param string $string
     * @param int $offset
     * @param int $limit
     * @return Collection|Channel[]
     */
    public function search(string $string, int $offset = 0, int $limit = 100): Collection
    {
        $index = $this->elasticSearchClient->search([
            'index' => $this->getIndex(),
            'body' => [
                'query' => [
                    'query_string' => [
                        'fields' => [
                            'title^5',
                            'description',
                        ],
                        'query' => $string . '*',
                        "analyze_wildcard" => true,
                        "allow_leading_wildcard" => true
                    ],
                ],
            ],
            'size' => $limit,
            'from' => $offset,
        ]);

        $collection = collect();

        foreach($index['hits']['hits'] as $source){
            $collection->push($this->makeModelBySource($source['_source']));
        }

        return $collection;
    }

    /**
     * @param Channel $channel
     * @return Channel
     */
    public function save(BaseEntity $channel): Channel
    {
        return parent::save($channel);
    }

    public function withVideos() : self
    {
        $this->withVideos = true;

        return $this;
    }

    public function withVideoStatistics() : self
    {
        $this->withVideoStatistics = true;

        return $this;
    }

    protected function makeModelBySource(array $source) : Channel
    {
        $channel = new Channel();
        $channel->setId($source['id']);
        $channel->setTitle($source['title']);
        $channel->setDescription($source['description']);
        $channel->setVideosCount($source['videosCount']);
        $channel->setViewsCount($source['viewsCount']);
        $channel->setSubscribersCount($source['subscribersCount']);

        if($this->withVideos){
            $channel->setVideos($this->getVideos($channel->getId()));
        }

        if($this->withVideoStatistics){
            $statistics = $this->getVideoStatistics($channel->getId());
            $channel->setVideoLikeCont($statistics['likes']);
            $channel->setVideoDislikeCont($statistics['dislikes']);
            $channel->setVideoLikesByDislikesQuotient(round($statistics['likesByDislikesQuotient'], 2));
        }

        return $channel;
    }

    private function getVideos(string $id) : Collection
    {
        return $this->videoRepository->getCollectionByChannelId($id);
    }

    private function getVideoStatistics(string $id) : array
    {
        return $this->videoRepository->getVideoStatisticsByChannelId($id);
    }
}