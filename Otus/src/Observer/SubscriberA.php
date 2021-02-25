<?php


namespace Otus\Observer;


use SplSubject;

class SubscriberA implements Observer
{
    public function update()
    {
        echo 'SubscriberA updated' . PHP_EOL;
    }
}