<?php
set_error_handler(function ($severity, $message, $file, $line) {
    throw new \ErrorException($message, $severity, $severity, $file, $line);
});

pcntl_async_signals(true);

function unlinkIfExist($filename) {
    if (file_exists($filename)) {
        unlink($filename);
    }
}