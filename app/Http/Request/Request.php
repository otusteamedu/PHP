<?php

namespace App\Http\Request;

use App\Helpers\AppConst;

class Request
{
    /**
     * @return string
     */
    public function getType(): string
    {
        if (php_sapi_name() === 'cli' || php_sapi_name() === 'cli-server')
            $requestType = AppConst::REQUEST_TYPE_CLI;
        else if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')
            $requestType = AppConst::REQUEST_TYPE_XHR;
        else
            $requestType = AppConst::REQUEST_TYPE_HTTP;

        return $requestType;
    }
}