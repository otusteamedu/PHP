<?php

namespace Socket;

use Exception;

/**
 * Class SocketRunnerValidator
 *
 * @package Socket
 */
class SocketRunnerValidator
{
    /**
     *
     */
    private const ALLOWED_MODES = [
        SocketRunner::SERVER_MODE_NAME,
        SocketRunner::CLIENT_MODE_NAME,
    ];

    /**
     * @param SocketRunner $runner
     *
     * @throws Exception
     */
    public static function validate (SocketRunner $runner)
    {
        if (!extension_loaded('sockets')) {
            throw new Exception('The sockets extension is not loaded');
        }

        if (php_sapi_name() !== 'cli') {
            throw new Exception('App only works in command line interface');
        }

        if (!in_array($runner->mode, self::ALLOWED_MODES)) {
            throw new Exception('Incorrect "mode" param');
        }
    }
}