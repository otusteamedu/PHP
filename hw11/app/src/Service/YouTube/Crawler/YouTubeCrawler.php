<?php

declare(strict_types=1);

namespace App\Service\YouTube\Crawler;

class YouTubeCrawler
{

    private YouTubeChannelCrawler       $channelCrawler;
    private YouTubeChannelVideosCrawler $channelVideosCrawler;

    public function __construct(
        YouTubeChannelCrawler $channelCrawler,
        YouTubeChannelVideosCrawler $channelVideosCrawler
    ) {
        $this->channelCrawler = $channelCrawler;
        $this->channelVideosCrawler = $channelVideosCrawler;
    }

    public function craw(array $channelIds): void
    {
        foreach ($channelIds as $channelId) {
            $this->channelCrawler->craw($channelId);
            $this->channelVideosCrawler->craw($channelId);
        }
    }

}