<?php

namespace App\Storage;

use App\Models\Channel;
use App\Models\Video;

class NoSQLStorage
{
    protected $client;

    public const INDEXES = [
        Channel::TABLE_NAME,
        Video::TABLE_NAME,
    ];
}