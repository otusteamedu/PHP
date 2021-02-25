<?php


namespace Otus\Observer;


interface Observable
{
    public function addObserver(Observer $observer);
    public function removeObserver(Observer $observer);
    public function notify();
}