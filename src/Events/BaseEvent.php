<?php


namespace Src\Events;


use Src\Subscribers\Subscriber;

abstract class BaseEvent implements Event
{
    /**
     * @var Subscriber[]
     */
    public array $subscribers = [];

    public function subscribe(Subscriber $subscriber) : void
    {
        $this->subscribers[] = $subscriber;
    }

    public function unsubscribe(Subscriber $subscriber) : void
    {
        $key = array_search($subscriber, $this->subscribers, true);

        if($key){
            unset($this->subscribers[$key]);
        }
    }

    public function notify() : void
    {
        foreach ($this->subscribers as $subscriber){
            $subscriber->handle($this);
        }
    }
}