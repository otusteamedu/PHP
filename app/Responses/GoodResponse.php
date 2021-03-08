<?php

namespace App\Responses;

class GoodResponse extends AbstractResponse
{
    /**
     * BadResponse constructor.
     *
     * @param int $httpStatusCode
     * @param string $httpStatusMessage
     */
    public function __construct(int $httpStatusCode = 200, string $httpStatusMessage = 'Request is valid!')
    {
        $this->httpStatusCode = $httpStatusCode;
        $this->httpStatusMessage = $httpStatusMessage;
    }
}
