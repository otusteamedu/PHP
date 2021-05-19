<?php

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