<?php


namespace Otushw;

class Stats
{
    const AGGR = 'AGGREGATION';
    const COLLECTION = 'COLLECTION';

    private int $likeCount = 0;
    private int $disLikeCount = 0;
    private VideoMapper $videoMapper;

    public function __construct(StorageInterface $storage)
    {
        $this->videoMapper = new VideoMapper($storage);

        if ($_ENV['TYPE_STATS'] == self::COLLECTION) {
            $this->getDataViaCollection();
        }
        if ($_ENV['TYPE_STATS'] == self::AGGR) {
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

    /**
     * @param int $likeCount
     */
    private function setLikeCount(int $likeCount)
    {
        $this->likeCount = $likeCount;
    }

    /**
     * @return int
     */
    private function getDisLikeCount(): int
    {
        return$this->disLikeCount;
    }

    /**
     * @param int $disLikeCount
     */
    private function setDisLikeCount(int $disLikeCount)
    {
        $this->disLikeCount = $disLikeCount;
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