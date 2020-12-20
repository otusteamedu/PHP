<?php

namespace Socket;

use Exception;

/**
 * Class SocketRunnerConfigReader
 *
 * @package Socket
 */
class SocketRunnerConfigReader
{
    /**
     *
     */
    private const CONFIG_PATH = '../config.ini';

    /**
     * @return array
     * @throws Exception
     */
    public static function read (): array
    {
        $config = parse_ini_file(self::CONFIG_PATH);

        if ($config === false) {
            throw new Exception('Config reading error');
        }

        return $config;
    }
}