<?php


namespace App\Model\Builders;


use DateTime;
use Google_Service_YouTube_SearchResultSnippet;
use App\Model\YouTubeChannel;

class ChannelBuilder
{
    public function buildFromGoogleResult(Google_Service_YouTube_SearchResultSnippet $snippet): YouTubeChannel
    {
        $model = new YouTubeChannel();

        $model->setId($snippet->getChannelId());
        $model->setTitle($snippet->getTitle());
        $model->setDescription($snippet->getDescription());
        $model->setPublishedAt(new DateTime($snippet->getPublishedAt()));

        return $model;
    }

    public function buildFromElasticResult(array $data): YouTubeChannel
    {
        $model = new YouTubeChannel();

        $model->setId($data['id']);
        $model->setTitle($data['title']);
        $model->setDescription($data['description']);
        $model->setPublishedAt(new DateTime($data['publishedAt']['date']));

        return $model;
    }

}
