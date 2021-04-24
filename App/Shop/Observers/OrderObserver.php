<?php

namespace App\Shop\Observers;

use SplObserver;

class OrderObserver implements \SplSubject
{
    private static ?OrderObserver $instance = null;


    private array $observers = [];

    public static function getInstance(): OrderObserver
    {
        if (is_null(self::$instance)) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    private function __construct()
    {
    }

    private function initEventType(string $event = '*'): OrderObserver
    {
        if (!isset($this->observers[$event])) {
            $this->observers[$event] = [];
        }
        return $this;
    }

    private function getEventObservers(string $event = '*'): array
    {
        return $this->initEventType($event)->observers[$event];
    }

    public function attach(SplObserver $observer, string $event = '*')
    {
        $this->initEventType($event)->observers[$event][] = $observer;
    }

    public function detach(SplObserver $observer, string $event = '*')
    {
        foreach ($this->getEventObservers($event) as $index => $obs) {
            if ($obs === $observer) {
                unset($this->observers[$event][$index]);
            }
        }
    }

    public function notify(string $event = '*', $data = null)
    {
        foreach ($this->getEventObservers($event) as $observer) {
            $observer->update($this, $event, $data);
        }
    }
}