<?php

namespace App\Services\Observer;

use App\Services\Factories\ProductFactory\AbstractProductBase;
use SplObserver;
use SplSubject;

class ProductObserver implements SplObserver
{
    /**
     * @var INotificator
     */
    private INotificator $notificator;


    /**
     * @param INotificator $notificator
     */
    public function __construct(INotificator $notificator)
    {
        $this->notificator = $notificator;
    }

    /**
     * @param AbstractProductBase|SplSubject $subject
     */
    public function update(AbstractProductBase|SplSubject $subject)
    {
        $message = $subject->getInfo() . PHP_EOL;
        $this->notificator->send($message);
    }
}