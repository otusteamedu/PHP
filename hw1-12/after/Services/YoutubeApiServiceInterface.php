<?php

interface YoutubeApiServiceInterface
{
    public function getChannelsInfo($channelId): ChannelDTO;

    public function getChannelVideos(string $channelId): array;
}