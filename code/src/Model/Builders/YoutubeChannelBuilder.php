<?php


namespace App\Model\Builders;


use DateTime;
use Google_Service_YouTube_SearchResultSnippet;
use App\Model\YoutubeChannel;
use App\Model\Interfaces\BuilderElasticsearchInterface;

class YoutubeChannelBuilder implements BuilderElasticsearchInterface
{
    public function buildFromGoogle(Google_Service_YouTube_SearchResultSnippet $snippet): YoutubeChannel
    {
        $model = new YoutubeChannel();

        $model->setId($snippet->getChannelId());
        $model->setTitle($snippet->getTitle());
        $model->setDescription($snippet->getDescription());
        $model->setPublishedAt(new DateTime($snippet->getPublishedAt()));

        return $model;
    }

    public function buildFromElasticResult(array $data): YoutubeChannel
    {
        $model = new YoutubeChannel();

        $model->setId($data['id']);
        $model->setTitle($data['title']);
        $model->setDescription($data['description']);
        $model->setPublishedAt(new DateTime($data['publishedAt']['date']));

        return $model;
    }

}
