<?php

namespace App\Contracts;

use App\Entities\YouTubeCategory;

interface YouTubeDriver
{
    /**
     * @param string $regionCode
     * @return array
     */
    public function getRegionCategories(string $regionCode): array;

    /**
     * @param YouTubeCategory $category
     * @return array
     */
    public function getCategoryChannels(YouTubeCategory $category): array;

    /**
     * @param string $channelId
     * @return array
     */
    public function getChannelVideos(string $channelId): array;

    /**
     * @param $videoId
     * @return array
     */
    public function getVideoStatistics($videoId): array;
}
