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
     *
     * @return BadResponse|GoodResponse
     */
    public function index(array $request) : AbstractResponse
    {
        try {
            $this->validateRequest($request);

            return new GoodResponse();

        } catch (BadRequestException $e) {
            return new BadResponse();
        }
    }
}
