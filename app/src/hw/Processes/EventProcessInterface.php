<?php


namespace Otus\Processes;


use Otus\Storage\StorageInterface;

interface EventProcessInterface
{
    public function process(StorageInterface $storage);
}