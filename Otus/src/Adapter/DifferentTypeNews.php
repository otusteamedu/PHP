<?php
namespace Otus\Adapter;

class DifferentTypeNews
{
    private $someData;

    public function setSomeData()
    {
        $this->someData = 'some data';
    }

    public function getDifferentNews()
    {
        echo 'different type of news:' . $this->someData . PHP_EOL;
    }
}