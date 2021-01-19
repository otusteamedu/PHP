<?php


namespace Otushw\Request;


use Otushw\Storage\StorageInterface;

interface Request
{
    public function process(StorageInterface $storage): void;
    public static function getTypeRequest(): string;
    public function showResult(): void;
}