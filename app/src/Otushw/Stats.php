<?php


namespace Otushw;


class Stats implements Application
{
    private $likeCount = 0;
    private $disLikeCount = 0;
    private $videoMapper;

    public function __construct($db)
    {
        $this->videoMapper = new VideoMapper($db);

        if ($_ENV['TYPE_STATS'] == 'COLLECTION') {
            $this->getDataViaCollection();
        }
        if ($_ENV['TYPE_STATS'] == 'AGGREGATION') {
            $this->getDataViaAggregation();
        }

        View::showStats($this->getLikeCount(), $this->getDisLikeCount(), $_ENV['TYPE_STATS']);
    }

    private function getLikeCount()
    {
        return $this->likeCount;
    }

    private function setLikeCount($likeCount)
    {
        $this->likeCount = $likeCount;
    }

    private function setDisLikeCount($disLikeCount)
    {
        $this->disLikeCount = $disLikeCount;
    }

    private function getDisLikeCount()
    {
        return$this->disLikeCount;
    }

    private function getDataViaCollection()
    {
        var_dump(__METHOD__);
        $likeCount = 0;
        $disLikeCount = 0;

        $raw = $this->videoMapper->getAll();
        $videoCollection = new VideoCollection($raw);
        foreach ($videoCollection as $key => $item) {
            $likeCount += $item->getLikeCount();
            $disLikeCount += $item->getDisLikeCount();
        }

        $this->setLikeCount($likeCount);
        $this->setDisLikeCount($disLikeCount);
    }

    private function getDataViaAggregation()
    {
        var_dump(__METHOD__);
        $likeCount = $this->videoMapper->getSumLikeCount();
        $this->setLikeCount($likeCount);
        $disLikeCount = $this->videoMapper->getSumDisLikeCount();
        $this->setDisLikeCount($disLikeCount);
    }
}