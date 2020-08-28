<?php

namespace Otus\Http\Controllers;

class MainController extends Controller
{
    public function index($params = null)
    {
        $requestParams = ['mail', 'mx'];
        $requestTypes = ['get', 'post'];

        foreach ($requestTypes as $requestType) {
            foreach ($requestParams as $requestParam) {
                if (!method_exists($this, $requestType)) {
                    continue;
                }

                $value = $this->{$requestType}($requestParam);
                if ($value) {
                    if ($this->isParamValid($requestParam, $value)) {
                        $this->response('OK');
                        return;
                    }
                }s
            }
        }

        $this->response('BAD', 422);
    }

    private function isParamValid(string $key, string $value): bool
    {
        if (
            $value !== ''
            && strlen($value) > 0
            && (
                ($key == 'mail' && preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i', $value))
                ||
                ($key == 'mx' && checkdnsrr($value, 'MX'))
            )
        ) {
            return true;
        }
        return false;
    }
}