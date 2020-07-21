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
        return $this;
    }

    public function setChannelName(string $channelName)
    {
        $this->channelName = $channelName;
        return $this;
    }

    public function setChannelVideoIds (array $channelVideoIds)
    {
        $this->channelVideoIds = $channelVideoIds;
        return $this;
    }


    public function build()
    {
        $this->validate();

        if (!empty($this->errors)) {
            throw new \RuntimeException(implode(';', $this->errors));
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
