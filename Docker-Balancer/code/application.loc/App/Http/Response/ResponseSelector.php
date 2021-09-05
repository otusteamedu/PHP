<?php

namespace App\Http\Response;

use App\Helpers\AppConst;
use App\Http\Request\Request;

/**
 * Выбирает формат ответа
 */
class ResponseSelector
{
    /**
     * Возвращает объект Response
     *
     * @return IResponse
     */
    public function getResponse(): IResponse
    {
        $requestType = (new Request())->getType();
        return match ($requestType) {
          AppConst::REQUEST_TYPE_HTTP => new ResponseHttp(),
          AppConst::REQUEST_TYPE_XHR => new ResponseXhr(),
          AppConst::REQUEST_TYPE_CLI => new ResponseCli(),
        };
    }
}