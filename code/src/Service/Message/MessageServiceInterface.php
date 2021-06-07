<?php

namespace App\Service\Message;



use App\Service\Message\Messages\MessageInterface;

interface MessageServiceInterface
{
    public function push(MessageInterface $message);
}
