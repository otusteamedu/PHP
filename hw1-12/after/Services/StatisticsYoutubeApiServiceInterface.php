<?php

interface StatisticsYoutubeApiServiceInterface
{
    public function getStats($channelId): array;
}