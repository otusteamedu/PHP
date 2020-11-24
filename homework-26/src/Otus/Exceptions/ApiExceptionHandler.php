<?php

namespace Otus\Exceptions;

use Otus\Http\JsonResponse;
use Otus\Http\Response;
use Throwable;

class ApiExceptionHandler implements ExceptionHandlerContract
{
    public function render(Throwable $throwable)
    {
        $response = new JsonResponse(Response::HTTP_INTERNAL_SERVER_ERROR, $throwable->getMessage());
        $response->send();
    }
}