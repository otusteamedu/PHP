<?php


namespace Otushw\Request;


use Otushw\Storage\StorageInterface;

interface Request
{
    public function process(StorageInterface $storage): void;
    public function getStatus(): string;
}