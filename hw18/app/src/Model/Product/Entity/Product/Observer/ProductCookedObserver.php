<?php

declare(strict_types=1);

namespace App\Model\Product\Entity\Product\Observer;

use App\Console\ConsoleInterface;
use App\Model\Product\Entity\Product\Events;
use App\Model\Product\Entity\Product\ProductInterface;

class ProductCookedObserver implements ObserverInterface
{
    private ConsoleInterface $console;

    public function __construct(ConsoleInterface $console)
    {
        $this->console = $console;
    }

    public function getEventName(): string
    {
        return Events::EVENT__COOKED;
    }

    public function handle(ObservableInterface $observable, string $eventName = ''): void
    {
        /* @var ProductInterface $observable */

        if ($eventName === $this->getEventName()) {
            $this->console->success($observable->getName() . ' приготовлен');
        }
    }
}