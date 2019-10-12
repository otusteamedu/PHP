<?php
declare(strict_types=1);
/**
 * @author Bazarov Aleksandr <bazarov@tutu.ru>
 *
 */


namespace APP\YouTubeInfo;


use APP\ChannelStorage;

class YouTubeChannelStatistics
{
    private $channelStorage;

    public function __construct()
    {
        $this->channelStorage = new ChannelStorage();
    }

    public function getLikesByChannelName(string $chanelName)
    {
        $chanel = $this->channelStorage->getChannelByName($chanelName);
        $likes = 0;
        foreach ($chanel['videos'] as $film) {
            $likes += $film['likes'];
        }
        return $likes;
    }

    public function getDislikesByChannelName(string $chanelName)
    {
        $chanel = $this->channelStorage->getChannelByName($chanelName);
        $dislikes = 0;
        foreach ($chanel['videos'] as $film) {
            $dislikes += $film['dislikes'];
        }
        return $dislikes;
    }

    public function getTopChannels(int $count): array
    {
        $channelRate = [];
        foreach ($this->channelStorage->getAllChannelsData() as $chanel) {
            $chanelName = $chanel['channelName'];
            $channelRate[$chanelName] =
                $this->getLikesByChannelName($chanelName) / $this->getDislikesByChannelName($chanelName);
        }
        arsort($channelRate);
        return array_slice($channelRate, 0, $count);
    }


}