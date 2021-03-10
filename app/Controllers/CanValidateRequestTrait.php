<?php

namespace App\Controllers;

use App\Exceptions\BadRequestException;

trait CanValidateRequestTrait
{
    /**
     * @param $request
     * @param $validatingRule
     *
     * @throws BadRequestException
     */
    protected function validateRequest($request, $validatingRule)
    {
        foreach ($validatingRule as $key => $rules) {
            //take key parameter from rules array and check if it is present in the request
            if (!isset($request[$key])) {
                throw new BadRequestException('Bad Request');
            }

            foreach ($rules as $rule) {
                if (!$rule($request[$key])) {
                    throw new BadRequestException('Bad Request');
                }
            }
        }
    }
}
