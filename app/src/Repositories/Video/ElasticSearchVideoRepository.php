<?php

namespace App\Repositories\Video;

use App\Entities\BaseEntity;
use App\Entities\Channel;
use App\Entities\Video;
use App\Repositories\BaseElasticSearchRepository;
use App\Repositories\Channel\ElasticSearchChannelRepository;
use Illuminate\Support\Collection;


class ElasticSearchVideoRepository extends BaseElasticSearchRepository implements VideoRepository
{
    protected const INDEX = 'videos';
    private bool $withChannel = false;

    /**
     * @return Collection|Video[]
     */
    public function getAll(): Collection
    {
        return parent::getAll();
    }

    /**
     * @param string $id
     * @return Video
     */
    public function getById(string $id): Video
    {
        return parent::getById($id);
    }

    /**
     * @param string $string
     * @param int $offset
     * @param int $limit
     * @return Collection|Video[]
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
     * @param BaseEntity $video
     * @return Video
     */
    public function save(BaseEntity $video): Video
    {
        return parent::save($video);
    }

    /**
     * @param string $channelId
     * @return Collection|Video[]
     */
    public function getCollectionByChannelId(string $channelId) : Collection
    {
        $index = $this->elasticSearchClient->search([
            'index' => $this->getIndex(),
            'body' => [
                'query' => [
                    'match' => [
                        'channelId' => $channelId
                    ],
                ],
            ],
            'size' => 10000
        ]);

        $collection = collect();

        foreach($index['hits']['hits'] as $source){
            $collection->push($this->makeModelBySource($source['_source']));
        }

        return $collection;
    }

    /**
     * @param string $channelId
     * @return Collection|Video[]
     */
    public function getVideoStatisticsByChannelId(string $channelId) : array
    {
        $index = $this->elasticSearchClient->search([
            'index' => $this->getIndex(),
            'body' => [
                'query' => [
                    'match' => [
                        'channelId' => $channelId
                    ],
                ],
                'aggs' => [
                    "statistics"=> [
                        "terms"=> [
                            "field" => "channelId",
                        ],
                        "aggs" => [
                            "likes" => [
                                "sum" => [
                                    "field" => "likeCount"
                                ]
                            ],
                            'dislikes' => [
                                'sum' => [
                                    "field" => "dislikeCount"
                                ]
                            ],
                            "likeByDislikeQuotient" => [
                                "bucket_script" => [
                                    "buckets_path" =>  [
                                        "sLikes" => "likes",
                                        "sDislikes" =>"dislikes"
                                    ],
                                    "script" => "if (params.sDislikes > 0) {
                                                    params.sLikes / params.sDislikes
                                                } else { 
                                                    params.sLikes 
                                                }"
                                ]
                            ]
                        ]
                    ]
                ],
                'size' => 0
            ],
        ]);

        return [
            'likes' => array_get(
                $index['aggregations']['statistics']['buckets'],
                '0.likes.value',
                0
            ),
            'dislikes' => array_get(
                $index['aggregations']['statistics']['buckets'],
                '0.dislikes.value',
                0
            ),
            'likesByDislikesQuotient' => array_get(
                $index['aggregations']['statistics']['buckets'],
                '0.likeByDislikeQuotient.value',
                0
            ),
        ];
    }

    public function withChannel(): VideoRepository
    {
        $this->withChannel = true;

        return $this;
    }

    /**
     * @param array $source
     * @return Video
     */
    protected function makeModelBySource(array $source) : Video
    {
        $video = new Video();
        $video->setId($source['id']);
        $video->setChannelId($source['channelId']);
        $video->setTitle($source['title']);
        $video->setDescription($source['description']);
        $video->setViewCount($source['viewCount']);
        $video->setDislikeCount($source['dislikeCount']);
        $video->setCommentCount($source['commentCount']);
        $video->setFavoriteCount($source['favoriteCount']);
        $video->setLikeCount($source['likeCount']);
        $video->setPublishedAt($source['publishedAt']);

        if($this->withChannel){
            $video->setChannel($this->getChannel($video->getChannelId()));
        }

        return $video;
    }

    private function getChannel(string $id) : Channel
    {
        $repository = new ElasticSearchChannelRepository();

        return $repository->getById($id);
    }
}