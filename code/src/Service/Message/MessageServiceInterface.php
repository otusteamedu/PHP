<?php

namespace App\Service\Message;


use App\Message\MessageInterface;

interface MessageServiceInterface
{
    public function push(MessageInterface $message);
}
