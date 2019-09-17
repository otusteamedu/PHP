<?php

namespace App\Contracts;

interface Transport
{
    public function read(): string;

    public function write(string $text);

    public function connect();

    public function serve();
}
