<?php

namespace Storage;

use Models\Channel;
use Models\Video;

class Mongo
{
    public const STORAGE_NAME = 'mongo';

    public const INDEXES = [
        Channel::TABLE_NAME,
        Video::TABLE_NAME,
    ];

    public function __construct()
    {

    }
}