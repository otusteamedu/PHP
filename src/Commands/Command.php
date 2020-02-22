<?php

namespace App\Commands;

interface Command
{
    const COMMAND_EXIT = 'exit';
    const ENV_SOCKET_SERVER = 'SOCKET_SERVER';
    const ENV_SOCKET_CLIENT = 'SOCKET_CLIENT';

    public static function getName(): string;
    public function process(): void;
}
