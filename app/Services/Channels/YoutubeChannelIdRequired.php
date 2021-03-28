<?php


namespace App\Services\Channels;


use Throwable;

class YoutubeChannelIdRequired extends \Exception
{
    public function __construct($message = "ChannelId is required", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
