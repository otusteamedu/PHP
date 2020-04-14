<?php


namespace Youtube;


use Youtube\DWH\Dwh;

class Statistic
{

    private function getTotalInfo($channelID = '')
    {
        if (!empty($channelID))
            $match = ['$match' => ['channel_id' => $channelID]];

        $group = [
            '$group' => [
                '_id' => ['_id' => null, 'channel_id' => '$channel_id'],
                'likes' => ['$sum' => '$statistics.likes'],
                'dislikes' => ['$sum' => '$statistics.dislikes']
            ]
        ];

        $project = [
            '$project' => [
                '_id' => 0,
                'channel_id' => '$_id.channel_id',
                'likes' => '$likes',
                'dislikes' => '$dislikes',
                'rating' => ['$divide' => ['$likes', ['$cond' => [ ['$eq' => ['$dislikes', 0]], 1, '$dislikes']] ]]
            ]
        ];

        //sort desc by rating
        $sort = ['$sort' => ['rating' => -1]];

        if (isset($match))
            $pipeline = [$match];
        $pipeline[] = $group;
        $pipeline[] = $project;
        $pipeline[] = $sort;

        $resp = Dwh::getInst()->getVideos()->aggregate($pipeline);
        if (!$resp)
            return false;

        $result = [];
        foreach ($resp->toArray() as &$row) {
            $item = [];
            foreach ($row as $key => $val)
                $item[$key] = $val;
            $result[] = $item;
        }

        return $result;
    }

    public function getSumLikeAndDislike($channelID)
    {
        $result = $this->getTotalInfo($channelID);
        $result = current($result);
        $keys = ['likes', 'dislikes'];
        return array_intersect_key($result, array_flip($keys));
    }

    public function getTop($limit = 3)
    {
        $list = $this->getTotalInfo();
        $top = array_slice($list, 0, $limit);
        return $top;
    }

}