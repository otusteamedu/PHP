<?php
function initSignal()
{
    pcntl_async_signals(true);
    pcntl_signal(SIGTERM, "sigHandler");
    pcntl_signal(SIGINT, "sigHandler");
}

function sigHandler($sigCode)
{
    global $App;

    if ($sigCode == SIGTERM || $sigCode == SIGINT) {
        unset($App);
        exit;
    }
}