<?php


namespace App\Services;


use App\Repository\YoutubeVideoQueryRepository;

class YoutubeStatisticHandler
{
    private YoutubeVideoQueryRepository $queryRepository;

    public function __construct()
    {
        $this->queryRepository = new YoutubeVideoQueryRepository();
    }

    public function getRatingList($data)
    {
        $videos = $this->queryRepository->getAllByName($data);
        $result['likes'] = 0;
        $result['dislikes'] = 0;
        foreach ($videos as $key => $video) {
            $result['likes'] += $video->likeCount;
            $result['dislikes'] += $video->dislikeCount;
        }
        return $result;
    }

    public function getTopChannels(int $topCount)
    {
        $channels = $this->queryRepository->getChannels();
        $top = [];
        foreach ($channels as $key => $channel) {
            $top[$channel] = $this->getRatingRatio($this->getRatingList($channel));
        }
        arsort($top);
        return array_slice($top, 0, $topCount);
    }

    private function getRatingRatio($data)
    {
        return $data['likes'] / $data['dislikes'];
    }

}