<?php


namespace App\Service\Message\Messages;


interface MessageInterface
{
    public function getHandler(): string;
    public function __serialize(): array;
    public function __unserialize(array $data): void;
}
