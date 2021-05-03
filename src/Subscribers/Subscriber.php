<?php


namespace Src\Subscribers;


use Src\Events\Event;

interface Subscriber
{
    public function handle(Event $event) : void;
}