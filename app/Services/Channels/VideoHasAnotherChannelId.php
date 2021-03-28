<?php


namespace App\Services\Channels;


use Throwable;

class VideoHasAnotherChannelId extends \Exception
{

    public function __construct($message = "The video has another channelId", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

}
