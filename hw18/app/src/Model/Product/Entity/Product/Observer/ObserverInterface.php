<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product\Observer;

interface ObserverInterface
{
    public function getEventName(): string;

    public function handle(ObservableInterface $observable, string $eventName = '');
}