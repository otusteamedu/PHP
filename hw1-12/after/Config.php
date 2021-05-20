<?php

/**
 * Class Config declare routes settings for app
 */
class Config
{
    public const ROUTES = [
        [
            'method' => 'GET',
            'path' => '/grub',
            'function' => 'grub()'
        ],
        [
            'method' => 'GET',
            'path' => '/statistics-channel-videos',
            'function' => 'getStatisticsChannelVideos()'
        ],
        [
            'method' => 'DELETE',
            'path' => '/deleting-indexes',
            'function' => 'delete()'
        ],
    ];
}