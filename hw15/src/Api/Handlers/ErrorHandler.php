<?php


namespace App\Api\Handlers;



class ErrorHandler extends Handler
{
    const ERR_SERVER = 1;
    const ERR_CMD = 2;

    const ERRORS = [
        self::ERR_SERVER => 'sorry',
        self::ERR_CMD => 'invalid request'
    ];

    public function __construct($errorCode = '')
    {
        parent::__construct();

        if ($errorCode)
            $this->setError($errorCode);
    }

    public function setError($errorCode)
    {
        if (!isset(self::ERRORS[$errorCode])) {
            $errorCode = 'uknown';
            $description = 'uknown error';
        } else
            $description = self::ERRORS[$errorCode];

        return $this->appendResultItem('error', ['code' => $errorCode, 'descr' => $description]);
    }

}
