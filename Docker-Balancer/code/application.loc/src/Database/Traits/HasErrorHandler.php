<?php

namespace Src\Database\Traits;


use ErrorException;


trait HasErrorHandler
{
    /**
     * pg_connect, mysqli, memprof
     * не бросают исключений поэтому нужно отловить ошибку и создать исключение самостоятельно
     *
     * @param $errno
     * @param $errstr
     * @param $errfile
     * @param $errline
     * @throws ErrorException
     */
    private function exception_error_handler($errno, $errstr, $errfile, $errline) {
        throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
    }
}