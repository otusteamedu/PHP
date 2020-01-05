<?php

namespace AI\backend_php_hw5_1\Http;

use AI\backend_php_hw5_1\Exceptions\MyException;
use AI\backend_php_hw5_1\Exceptions\HttpRequestException;
use AI\backend_php_hw5_1\Validators\Validator;

class RequestHandler
{
    /**
     * @param array $request
     * @param Validator $validator
     *
     * @throws MyException
     */
    public function proceed(array $request, Validator $validator): void
    {
        if ($this->hasAllRequiredParams($request)) {
            $validator->check($request['string']);
        } else {
            throw new HttpRequestException("Не получен параметр 'string'");
        }
    }

    /**
     * @param array $request
     *
     * @return bool
     */
    private function hasAllRequiredParams(array $request)
    {
        return isset($request['string']);
    }
}
