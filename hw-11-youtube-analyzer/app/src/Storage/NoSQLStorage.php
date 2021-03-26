<?php

namespace App\Storage;

/*use Models\Channel;
use Models\Video;*/

class NoSQLStorage
{
    protected $client;

    public const INDEXES = [
        'channels',
        'videos',
    ];
}