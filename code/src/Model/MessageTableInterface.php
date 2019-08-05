<?php

namespace crazydope\theater\Model;

interface MessageTableInterface
{
    public function insert(MessageInterface $message): string;

    public function get(string $uuid): ?MessageInterface;

    public function update(MessageInterface $message): int;

    public function delete(string $uuid): int;
}