<?php

namespace App\Core\RenderObserver;

interface Observable
{
    public function addObserver(ObserverInterface $observer): void;
    public function removeObserver(ObserverInterface $observer): void;
    public function notifyObservers(): void;
}