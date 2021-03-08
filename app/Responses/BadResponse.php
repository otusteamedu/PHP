<?php

namespace App\Responses;

class BadResponse extends AbstractResponse
{
    /**
     * BadResponse constructor.
     *
     * @param int $httpStatusCode
     * @param string $httpStatusMessage
     */
    public function __construct(int $httpStatusCode = 400, string $httpStatusMessage = 'Bad request!')
    {
        $this->httpStatusCode = $httpStatusCode;
        $this->httpStatusMessage = $httpStatusMessage;
    }
}
