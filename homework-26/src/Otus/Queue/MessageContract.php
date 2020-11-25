<?php

namespace Otus\Queue;

interface MessageContract
{
    public function getData(): string;
}