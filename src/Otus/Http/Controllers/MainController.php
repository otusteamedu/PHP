<?php

namespace Otus\Http\Controllers;

class MainController extends Controller
{
    public function index($params = null)
    {
        $requestParams = ['string'];
        $requestTypes = ['get', 'post'];

        foreach ($requestTypes as $requestType) {
            foreach ($requestParams as $requestParam) {
                if (!method_exists($this, $requestType)) {
                    continue;
                }

                $value = $this->{$requestType}($requestParam);
                if ($value) {
                    if ($this->isParamValid($value)) {
                        $this->response('OK');
                        return;
                    }
                }
            }
        }

        $this->response('BAD', 422);
    }

    private function isParamValid(string $value): bool
    {
        if (
            $value !== ''
            && strlen($value) > 0
            && preg_match('/^[^()]*+(\((?>[^()]|(?1))*+\)[^()]*+)++$/', $value)
        ) {
            return true;
        }
        return false;
    }
}