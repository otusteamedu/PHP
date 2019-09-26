<?php
declare(strict_types=1);

class Statistics
{
    private $storage;
    
    private $chanelList = [];
    
    public function __construct(MongoStorage $storage)
    {
        $this->storage = $storage;
        $this->chanelList = $storage->getChannels();
    }
    
    public function getLikesByChannelName(string $chanelName)
    {
        $chanel = $this->storage->getChannelByName($chanelName);
        $likes = 0;
            foreach ($chanel['films'] as $film) {
                $likes += $film['likes'];
            }
        return $likes;
    }
    
    public function getDislikesByChannelName(string $chanelName)
    {
        $chanel = $this->storage->getChannelByName($chanelName);
        $dislikes = 0;
            foreach ($chanel['films'] as $film) {
                $dislikes += $film['dislike'];
            }
        return $dislikes;
    }
    
    public function getTopChannels(int $count)
    {
        $channelWithRelations = [];
        foreach ($this->chanelList as $chanel) {
            $chanelName = $chanel['channelName'];
            $channelWithRelations[$chanelName] = 
                $this->getLikesByChannelName($chanelName) / $this->getDislikesByChannelName($chanelName);
        }
        arsort($channelWithRelations);
        return array_slice($channelWithRelations, 0, $count);
    }

}