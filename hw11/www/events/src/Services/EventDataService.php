<?php

namespace App\Services;

use Buzz\Browser;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * Class YoutubeClientService
 * @package App\Services
 */
class EventDataService
{
    public function generateKey(): string
    {
        $key = bin2hex(random_bytes(5));
        return 'events:'. $key;
    }
}