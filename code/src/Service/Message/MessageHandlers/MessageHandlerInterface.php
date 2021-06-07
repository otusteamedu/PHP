<?php


namespace App\Service\Message\MessageHandlers;


use App\Service\Message\Messages\MessageInterface;

interface MessageHandlerInterface
{
    public function process(MessageInterface $message);
}
