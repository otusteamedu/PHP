<?php

namespace App\Core\RenderObserver;

interface ObserverInterface
{
    public function update(Observable $object): void;
}