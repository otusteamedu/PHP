<?php

namespace Classes\Dto;

class ChannelDtoBuilder
{
    private $errors;

    private $channelId;
    private $channelName;
    private $channelVideoIds = [];

    public function setChannelId(string $channelId)
    {
        $this->channelId = $channelId;
    }

    public function setChannelName(string $channelName)
    {
        $this->channelName = $channelName;
    }

    public function setChannelVideoIds (array $channelVideoIds)
    {
        $this->channelVideoIds = $channelVideoIds;
    }


    public function build()
    {
        $this->validate();

        if (!empty($this->error)) {
            throw new \RuntimeException(implode(';', $this->error));
        }
        return ChannelDto::build($this);
    }

    public function validate()
    {
        if (empty($this->channelId)) {
            $this->errors[] = 'Не задан id канала';
        }

        if (empty($this->channelName)) {
            $this->errors[] = 'Не задано имя канала';
        }

        if (empty($this->channelVideoIds)) {
            $this->errors[] = 'Не задан массив видео канала';
        }

    }

    public function getChannelId()
    {
        return $this->channelId;
    }

    public function getChannelName()
    {
        return $this->channelName;
    }

    public function getChannelVideosIds()
    {
        return $this->channelVideoIds;
    }
}
