<?php


namespace Src\Events;

use Src\Subscribers\Subscriber;

interface Event
{
    public function subscribe(Subscriber $subscriber) : void;

    public function unsubscribe(Subscriber $subscriber) : void;

    public function notify() : void;
}