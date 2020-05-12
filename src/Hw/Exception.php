<?php
namespace Hw4;

use RuntimeException;

class Exception extends RuntimeException {

    public static function fromSocketResource($resource) {
        if (is_resource($resource)) {
            $code = socket_last_error($resource);
            socket_clear_error($resource);
        } else {
            // socket already closed, return fixed error code instead of operating on invalid handle
            $code = SOCKET_ENOTSOCK;
        }
        return new self(socket_strerror($code), $code);
    }
}