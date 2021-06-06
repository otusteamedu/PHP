<?php


namespace App\ConsoleCommands\Commands;


interface Command
{
    public function run(array $argv) : string;
}