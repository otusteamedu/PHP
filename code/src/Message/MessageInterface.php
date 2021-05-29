<?php


namespace App\Message;



interface MessageInterface
{
    public function getHandler(): string;
    public function __serialize(): array;
    public function __unserialize(array $data): void;
}
