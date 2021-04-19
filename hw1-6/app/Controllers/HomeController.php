<?php

namespace App\Controllers;

use App\Responses\BadResponse;
use App\Responses\GoodResponse;
use App\Responses\AbstractResponse;
use App\Exceptions\BadRequestException;

class HomeController
{
    use CanValidateRequestTrait;

    /**
     * @param array $request
     * @param array $validatingRule
     *
     * @return BadResponse|GoodResponse
     */
    public function index(array $request, array $validatingRule): AbstractResponse
    {
        try {
            $this->validateRequest($request, $validatingRule);

            return new GoodResponse();

        } catch (BadRequestException $e) {
            return new BadResponse();
        }
    }

    /**
     * @param array $request
     * @param array $validatingRule
     *
     * @return AbstractResponse
     */
    public function verifyEmail(array $request, array $validatingRule): AbstractResponse
    {
        try {
            $this->validateRequest($request, $validatingRule);

            return new GoodResponse();

        } catch (BadRequestException $e) {
            return new BadResponse();
        }
    }
}
