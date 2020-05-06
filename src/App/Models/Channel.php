<?php

namespace Ozycast\App\Models;

use Ozycast\App\App;
use Ozycast\App\Mappers\ChannelMapper;

Class Channel
{
    /**
     * Добавить новый канал
     * @param string $id
     * @return array
     * @throws \Exception
     */
    public function addChannel(string $id)
    {
        $channel = Youtube::getChannel($id);
        if (!$channel)
            return ['status' => 0, 'message' => 'Channel not found'];

        // Избавимся от дублей
        if ((new ChannelMapper(App::$db))->findOne(['id' => $channel->id]))
            return ['status' => 0, 'message' => 'Channel added earlier'];

        $channel = [
            'id' => $channel->id,
            'title' => $channel->snippet->title,
        ];

        (new ChannelMapper(App::$db))->insert($channel);
        return ['status' => 1, 'message' => 'Done!'];
    }

    /**
     * Все каналы
     * @return array
     */
    public function channels()
    {
        $channels = (new ChannelMapper(App::$db))->findAll();
        if (!$channels)
            return ['status' => 0, 'message' => 'channels not found'];

        return ['status' => 1, 'message' => 'Done!', 'data' => $channels];
    }
}