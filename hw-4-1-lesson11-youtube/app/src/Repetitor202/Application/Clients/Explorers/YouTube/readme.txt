test-version of file: YouTubeClient.php

<?php


namespace Repetitor202\Application\Clients\Explorers\YouTube;

class YouTubeClient
{
    /**
     * example
     */
    public function getChannel(string $channelId): array
    {
        return [
            'id' => 'c1',
            'title' => 'title c1',
            'videos' => [
                [
                    'id' => 'v1_1',
                    'channelId' => 'c1',
                    'likeCount' => 100,
                    'dislikeCount' => 15,
                    'title' => 'title v1_1',
                ],
                [
                    'id' => 'v1_2',
                    'channelId' => 'c1',
                    'likeCount' => 100,
                    'dislikeCount' => 15,
                    'title' => 'title v1_2',
                ],
                [
                    'id' => 'v1_3',
                    'channelId' => 'c1',
                    'likeCount' => 100,
                    'dislikeCount' => 15,
                    'title' => 'title v1_3',
                ],
            ],
        ];
    }