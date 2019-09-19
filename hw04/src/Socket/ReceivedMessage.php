<?php

namespace App\Socket;

class ReceivedMessage
{
    public $content = '';
    public $from = '';
    public $receivedBytes = 0;

    public function __construct(string $message, string $from, int $receivedBytes)
    {
        $this->content = $message;
        $this->from = $from;
        $this->receivedBytes = $receivedBytes;

        $extPos = strpos($from, $ext = '.sock');
        $this->from = substr($from, 0, $extPos + strlen($ext));
    }
}
