<?php


namespace Youtube;


use HW\AppInterface;
use Youtube\DWH\Dwh;

class App implements AppInterface
{

    public function run()
    {
        $stat = new Statistic();

        $channelID = Dwh::getInst()->getChannels()->findOne()['_id'];

        $result1 = [
            'channelID' => $channelID,
            'total' => $stat->getSumLikeAndDislike($channelID)
        ];

        $result2 = [
            'top' => $stat->getTop()
        ];

        echo json_encode(['result1' => $result1, 'result2' => $result2]);
    }

}