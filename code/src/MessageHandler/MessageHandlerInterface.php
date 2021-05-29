<?php


namespace App\MessageHandler;


use App\Message\MessageInterface;

interface MessageHandlerInterface
{
    public function process(MessageInterface $message);
}
