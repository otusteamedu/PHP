<?php
require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/YouTubeApi.php';

class Statistic
{
    private $channel = [];
    private $collection;

    public function __construct()
    {
        $this->collection = (new MongoDB\Client)->test->channels;


        $documents = $this->collection->find()->toArray();
        foreach ($documents as $document) {
            $this->channel[] = $document->jsonSerialize();
        }

    }

    public function addChannel(YouTubeApi $api, string $IdChannel)
    {
        $arrayData = $api->findChannel($IdChannel);
        $snippet = $arrayData['snippet'];
        $statistics = $arrayData['statistics'];

        if ($this->collection->findOne(['name' => $snippet->getTitle()]) == null) {

            $this->collection->insertOne([
                'name' => $snippet->getTitle(),
                'videos' => $statistics->getVideoCount(),
                'comments' => $statistics->getCommentCount(),
                'views' => $statistics->getViewCount(),
                'subscibers' => $statistics->getSubscriberCount(),
            ]);
        } else {
            $this->collection->updateOne(
                ['name' => $snippet->getTitle()],
                ['$set' => [
                    'videos' => $statistics->getVideoCount(),
                    'comments' => $statistics->getCommentCount(),
                    'views' => $statistics->getViewCount(),
                    'subscibers' => $statistics->getSubscriberCount(),
                ],
                ]
            );
        }

        echo $snippet->getTitle();
    }

    public function deleteChannel(string $name)
    {
        $this->collection->deleteOne(['name' => $name]);
    }

    private function getAll()
    {
        return $this->channel;
    }

    public function getViews()
    {
        usort($this->channel, function ($a, $b) {
            return $a->views < $b->views;
        });

        return $this->getAll();
    }

    public function getVideos()
    {
        usort($this->channel, function ($a, $b) {
            return $a->videos < $b->videos;
        });

        return $this->getAll();
    }

}