<?php

namespace Ozycast\App;

Class Channel extends ChannelModel
{
    /**
     * Добавить новый канал
     * @param $id
     * @return array
     */
    public function addChannel($id)
    {
        $channel = Youtube::getChannel($id);
        if (!$channel)
            return ['status' => 0, 'message' => 'Channel not found'];

        // Избавимся от дублей
        if (ChannelModel::find(['id' => $channel->id]))
            return ['status' => 0, 'message' => 'Channel added earlier'];

        $model = new ChannelModel();
        $model->id = $channel->id;
        $model->title = $channel->snippet->title;

        if (!$model->save())
            return ['status' => 0, 'message' => $model->getError()];

        return ['status' => 1, 'message' => 'Done!'];
    }

    /**
     * Все каналы
     * @return array
     */
    public function channels()
    {
        $channels = (new ChannelModel())->findAll();
        if (!$channels)
            return ['status' => 0, 'message' => 'channels not found'];

        return ['status' => 1, 'message' => 'Done!', 'data' => $channels];
    }
}