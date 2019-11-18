<?php

namespace Ymdb;

class MetrikaClass
{
    private $mongo;

    public $channelCount;
    public $videoCount;
    public $likeCount;
    public $dislikeCount;
    public $arrChannels;
    public $likest;
    public $dislikest;

    public function __construct()
    {
        $this->mongo = new \MongoDB\Client('mongodb://mongodb');

    }

    public function setChannelCount()
    {
        $collection = $this->mongo->test->channels;
        $this->channelCount = $collection->count();

        return $this;
    }

    public function setVideoCount()
    {
        $collection = $this->mongo->test->videos;
        $this->videoCount = $collection->count();

        return $this;
    }

    public function setLikeCount()
    {
        $collection = $this->mongo->test->videos;
        $sum = $collection->aggregate([
            ['$group' => ['_id' => 1, 'sum' => ['$sum' => '$likeCount']]],
            ['$limit' => 1],
        ])->toArray()[0]["sum"];

        $this->likeCount = $sum;

        return $this;
    }

    public function setDislikeCount()
    {
        $collection = $this->mongo->test->videos;
        $sum = $collection->aggregate([
            ['$group' => ['_id' => 1, 'sum' => ['$sum' => '$dislikeCount']]],
            ['$limit' => 1],
        ])->toArray()[0]["sum"];

        $this->dislikeCount = $sum;
        return $this;
    }

    public function setArrChannels()
    {
        $collection = $this->mongo->test->videos;
        $arrChannel = $collection->aggregate([
            ['$group' => ['_id' => '$channelId',
                'channelTitle' => ['$first' => '$channelTitle'],
                'video' => ['$sum' => 1],
                'like' => ['$sum' => '$likeCount'],
                'dislike' => ['$sum' => '$dislikeCount']]],
        ])->toArray();

        $arrTotal = [];
        foreach ($arrChannel as $i => $channel) {
            // $arrTotal[$i]["_id"] = $channel["_id"]; // уберем пока для красоты
            $arrTotal[$i]["channelTitle"] = $channel["channelTitle"];
            $arrTotal[$i]["video"] = $channel["video"];
            $arrTotal[$i]["like"] = $channel["like"];
            $arrTotal[$i]["dislike"] = $channel["dislike"];
            if ($arrTotal[$i]["dislike"]) {
                $arrTotal[$i]["channelRate"] = round($arrTotal[$i]["like"] / $arrTotal[$i]["dislike"], 2);
            }
        }

        $this->arrChannels = $arrTotal;
        return $this;
    }

}
