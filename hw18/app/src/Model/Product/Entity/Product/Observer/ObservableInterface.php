<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product\Observer;

interface ObservableInterface
{
    public function addObserver(ObserverInterface $observer, string $eventName = '*'): void;
    public function removeObserver(ObserverInterface $observer, string $eventName = '*'): void;
    public function notify(string $eventName = '*'): void;
}