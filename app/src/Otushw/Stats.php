<?php


namespace Otushw;


use Otushw\DBSystem\NoSQLDAO;

class Stats implements Application
{
    private int $likeCount = 0;
    private int $disLikeCount = 0;
    private VideoMapper $videoMapper;

    public function __construct(NoSQLDAO $db)
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

    /**
     * @return int
     */
    private function getLikeCount(): int
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

    /**
     * @return int
     */
    private function getDisLikeCount(): int
    {
        return$this->disLikeCount;
    }

    private function getDataViaCollection()
    {
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
        $likeCount = $this->videoMapper->getSumLikeCount();
        $this->setLikeCount($likeCount);
        $disLikeCount = $this->videoMapper->getSumDisLikeCount();
        $this->setDisLikeCount($disLikeCount);
    }
}