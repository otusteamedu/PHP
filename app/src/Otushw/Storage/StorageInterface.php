<?php


namespace Otushw\Storage;

use Otushw\EventDTO;

interface StorageInterface
{
    public function get($source);
    public function set(EventDTO $event): bool;
    public function clear();
}