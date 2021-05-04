<?php


namespace Src\Subscribers;


use Src\Events\Event;

class CheckPlayLevel implements Subscriber
{
    public function handle(Event $event): void
    {
        $play = $event->getPlay();

        $userScore = $play->getUser()->getScore();

        if($play->getCurrentLevel()->getNeedScore() <= $userScore){
            $play->improveLevel();
        }
    }
}