<?php

namespace Storage;

use Models\Channel;
use Models\Video;

class NoSQLStorage
{
    protected $client;

    public const INDEXES = [
        Channel::TABLE_NAME,
        Video::TABLE_NAME,
    ];
}