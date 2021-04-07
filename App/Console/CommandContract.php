<?php


namespace App\Console;


interface CommandContract
{
    public function __construct(array $arguments = []);

    public function handle();
}