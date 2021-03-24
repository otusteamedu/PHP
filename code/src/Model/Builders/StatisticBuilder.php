<?php


namespace App\Model\Builders;


use App\Model\ChannelStatistic;

class StatisticBuilder
{
    public function buildFromElasticResult(array $data): ChannelStatistic
    {
        $model = new ChannelStatistic();

        $model->setChannelId($data['hits']['hits'][0]['_source']['channelId'] ?? '');
        $model->setLikesCount((int) $data['aggregations']['likesCount']['value']);
        $model->setDislikesCount((int) $data['aggregations']['dislikesCount']['value']);

        return $model;
    }

}
