<?php


namespace Youtube;


use Youtube\DWH\Dwh;

class App
{

    public function run()
    {
        $this->printStatistic1();
        $this->printStatistic2();
        return;
    }

    /**
     * print accumulated likes and dislikes of all videos of random channel
     */
    private function printStatistic1()
    {
        $stat = new Statistic();

        $channelID = Dwh::getInst()->getChannels()->findOne()['_id'];

        $res = $stat->getSumLikeAndDislike($channelID);
        echo "<pre>";
        echo "channelID = $channelID<br>";
        print_r($res);
        echo "</pre>";

    }

    private function printStatistic2()
    {
        $stat = new Statistic();
        $res = $stat->getTop();
        echo "<pre>";
        print_r($res);
        echo "</pre>";

    }

}