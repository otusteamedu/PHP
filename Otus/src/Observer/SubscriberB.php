<?php


namespace Otus\Observer;


class SubscriberB implements Observer
{

    public function update()
    {
        echo 'SubscriberB updated' . PHP_EOL;
    }
}