<?php

namespace App\Commands;

interface Command
{
    public const COMMAND_EXIT = 'exit';
    public const ENV_SOCKET_SERVER = 'SOCKET_SERVER';
    public const ENV_SOCKET_CLIENT = 'SOCKET_CLIENT';
    public const ENV_LOG_DIR = 'LOGS_DIR';
    public const ENV_PID_FILE = 'PID_FILE';

    public function process(): void;
}
