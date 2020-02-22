<?php

namespace App\Commands;

use App\Services\Message;

class ServerStop implements Command
{
    public function process(): void
    {
        $pidFile = getenv(self::ENV_PID_FILE) ?: '/tmp/server.pid';

        if (is_file($pidFile)) {
            $pid = file_get_contents($pidFile);
            if (posix_kill($pid, SIG_BLOCK)) {
                posix_kill($pid, SIGTERM);
                unlink($pidFile);

                Message::info('Остановка сервера');
            }
        }
    }
}
