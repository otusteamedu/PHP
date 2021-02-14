<?php

declare(strict_types=1);

namespace Nlazarev\Hw2_1\Model\Sockets\Traits;

trait HasUnixSocket
{
    private bool $is_unix = false;

    protected function createUnixSocket()
    {
        $this->is_unix = true;

        try {
            if (!($instance = socket_create(AF_UNIX, SOCK_STREAM, 0))) {
                $errorcode = socket_last_error();
                $errormsg = socket_strerror($errorcode);
                throw new \Exception('Socket error: [$errorcode] $errormsg');
                $instance = null;
                //TODO: Loging
            }
        } catch (\Exception $e) {
            $instance = null;
            //TODO: Loging
        }

        return $instance;
    }

    public function isUnixSocket(): bool
    {
        if ($this->is_unix) {
            return true;
        } else {
            return false;
        }
    }

    protected function preparePath(string $path): bool
    {
        if (!$this->isUnixSocket()) {
            throw new \Exception('Socket error: It is not a valid unix-socket');
            //TODO: Loging
            return false;
        }

        if (file_exists($path)) {
            if (!unlink($path)) {
                throw new \Exception('Socket error: Access to socket-file is blocked (not unlinked)');
                //TODO: Loging
                return false;
            }
        }

        return true;
    }
}
