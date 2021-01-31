<?php


namespace Otushw\Exception;

use Exception;

/**
 * Class SocketException
 *
 * @package Otushw\Exception
 */
class SocketException extends AppException
{

    /**
     * @param $message
     *
     * @return string
     */
    public function processMsg($message): string
    {
        $errorMsg = $this->getLastError();
        return $message . ' | ' . $errorMsg;
    }

    /**
     * @return string
     */
    private function getLastError(): string
    {
        $errorcode = socket_last_error();
        return socket_strerror($errorcode);
    }
}