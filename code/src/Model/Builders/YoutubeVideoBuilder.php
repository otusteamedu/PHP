<?php


namespace App\Model\Builders;


use App\Model\Interfaces\BuilderElasticsearchInterface;
use App\Model\YoutubeVideo;
use DateTime;
use Google_Service_YouTube_Video;

class YoutubeVideoBuilder implements BuilderElasticsearchInterface
{
    public function buildFromGoogle(Google_Service_YouTube_Video $video): YoutubeVideo
    {
        $model = new YoutubeVideo();

        $snippet = $video->getSnippet();

        $model->setId($snippet->getChannelId());
        $model->setTitle($snippet->getTitle());
        $model->setDescription($snippet->getDescription());
        $model->setPublishedAt(new DateTime($snippet->getPublishedAt()));
        $model->setChannelId($snippet->getChannelId());

        $tags = $snippet->getTags() ?? [];
        $model->setTags($tags);

        $statistic = $video->getStatistics();

        $model->setViewCount($statistic->getViewCount() ?? 0);
        $model->setLikeCount($statistic->getLikeCount() ?? 0);
        $model->setDislikeCount($statistic->getDislikeCount() ?? 0);
        $model->setFavoriteCount($statistic->getFavoriteCount() ?? 0);
        $model->setCommentCount($statistic->getCommentCount() ?? 0);

        return $model;
    }

    public function buildFromElasticResult(array $data): YoutubeVideo
    {
        $model = new YoutubeVideo();

        $model->setId($data['id']);
        $model->setTitle($data['title']);
        $model->setDescription($data['description']);
        $model->setPublishedAt(new DateTime($data['publishedAt']['date']));
        $model->setTags($data['tags']);
        $model->setChannelId($data['channelId']);

        $model->setViewCount($data['viewCount']);
        $model->setLikeCount($data['likeCount']);
        $model->setDislikeCount($data['dislikeCount']);
        $model->setFavoriteCount($data['favoriteCount']);
        $model->setCommentCount($data['commentCount']);

        return $model;
    }

}
