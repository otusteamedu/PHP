<?php

namespace App\Storage;

class Redis extends NoSQLStorage
{
    public const STORAGE_NAME = 'redis';

    protected $client;

    public function __construct()
    {

    }
}