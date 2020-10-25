<?php

namespace App\Models;

use App\Core\RenderObserver\Observable;
use App\Core\RenderObserver\ObserverInterface;
use App\Core\Templates\RenderPage;

class BaseModel implements ObserverInterface
{
    /**
     * BaseModel constructor.
     */
    public function __construct()
    {
        $observer = new RenderPage();
        $observer->addObserver($this);
    }

    public function update(Observable $object): void
    {
        // TODO: Implement update() method.
    }
}