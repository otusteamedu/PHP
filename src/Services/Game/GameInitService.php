<?php


namespace Src\Services\Game;


use Src\Entities\Play;
use Src\Entities\PlayGround;
use Src\Entities\User;

class GameInitService
{
    public function start() : Play
    {
        $playLevels = $this->initPlayLevels();

        $play = new Play();
        $play->setUser($this->initUser());
        $play->setPlayGround($this->initPlayGround());
        $play->setLevels($playLevels);
        $play->setCurrentLevel(current($playLevels));
        $play->setEvents($this->initEvents());

        return $play;
    }

    private function initEvents() : array
    {
        $events = [];

        foreach(EVENTS as $eventClass){
            if(!isset(EVENT_SUBSCRIBERS[$eventClass])){
                continue;
            }

            $event = new $eventClass();

            foreach(EVENT_SUBSCRIBERS[$eventClass] as $subscriber){
                $event->subscribe(new $subscriber());
            }

            $events[$eventClass] = $event;
        }

        return $events;
    }

    private function initUser() : User
    {
        return new User();
    }

    private function initPlayGround() : PlayGround
    {
        return new PlayGround(PLAY_GROUND_SIZE[0], PLAY_GROUND_SIZE[1]);
    }

    private function initPlayLevels() : array
    {
        $levels = [];
        foreach(LEVELS_CONFIG as $levelConfig){
            $levels[] =  new \Src\Entities\PlayLevel($levelConfig['speed'], $levelConfig['needScore']);
        }

        return $levels;
    }
}