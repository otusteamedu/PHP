<?php


namespace Src\Entities;


use Src\Elements\Element;
use Src\Events\Event;

class Play
{
    private User $user;
    private PlayGround $playGround;
    private PlayLevel $currentLevel;
    private array $events;
    private ?Element $currentElement = null;

    /**
     * @var array | PlayLevel[]
     */
    private array $levels;

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return PlayGround
     */
    public function getPlayGround(): PlayGround
    {
        return $this->playGround;
    }

    /**
     * @param PlayGround $playGround
     */
    public function setPlayGround(PlayGround $playGround): void
    {
        $this->playGround = $playGround;
    }

    /**
     * @return array
     */
    public function getLevels(): array
    {
        return $this->levels;
    }

    /**
     * @param array $levels|PlayLevels[]
     */
    public function setLevels(array $levels): void
    {
        $this->levels = $levels;
    }

    /**
     * @return PlayLevel
     */
    public function getCurrentLevel(): PlayLevel
    {
        return $this->currentLevel;
    }

    /**
     * @param PlayLevel $currentLevel
     */
    public function setCurrentLevel(PlayLevel $currentLevel): void
    {
        $this->currentLevel = $currentLevel;
    }

    /**
     * @param array|Event[] $events
     */
    public function setEvents(array $events): void
    {
        $this->events = $events;
    }

    /**
     * @return array|Event[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @return Element
     */
    public function getCurrentElement(): Element
    {
        return $this->currentElement;
    }

    /**
     * @param Element $currentElement
     */
    public function setCurrentElement(Element $currentElement): void
    {
        $this->currentElement = $currentElement;
    }

    public function removeCurrentElement(): void
    {
        $this->currentElement = null;
    }

    public function improveLevel()
    {
        if(current($this->levels) === $this->levels[count($this->levels) - 1]){
            $nextLevel = current($this->levels);
        } else {
            $nextLevel = next($this->levels);
        }

        return $this->currentLevel = $nextLevel;
    }

}