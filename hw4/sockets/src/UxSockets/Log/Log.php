<?php

namespace UxSockets\Log;

class Log
{
    private string $logfile;

    public function __construct(string $logfile)
    {
        $this->logfile = __DIR__ . '/' . $logfile;
    }

    public function addLogNote(string $msg): void
    {
        $msg = date('Y-m-d H:i:s') . ' - ' . $msg . PHP_EOL;
        file_put_contents($this->logfile, $msg, FILE_APPEND);
    }
}
