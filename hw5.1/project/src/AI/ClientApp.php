<?php

namespace AI\backend_php_hw5_1;

use AI\backend_php_hw5_1\Input\CommandLine;
use AI\backend_php_hw5_1\Input\GetRequestParams;
use AI\backend_php_hw5_1\Http\PostRequestHandler;
use AI\backend_php_hw5_1\Exceptions\MyException;
use AI\backend_php_hw5_1\View\View;
use AI\backend_php_hw5_1\Http\Response;

class ClientApp
{
    /**
     * @return array
     */
    public function getInput(): array
    {
        if (PHP_SAPI == 'cli') {
            $input = new CommandLine();
        } else {
            $input = new GetRequestParams();
        }

        return $input->getParams();
    }

    /**
     * @param string $url
     * @param array $requestParams
     *
     * @return array
     */
    public function executeRequest(string $url, array $requestParams): array
    {
        $requestHandler = new PostRequestHandler($url, $requestParams);
        $result = [];

        try {
            $result['responseInfo'] = $requestHandler->proceed();
            $result['responseCode'] = Response::OK . ' OK';
        } catch (MyException $exception) {
            $result['responseInfo'] = $exception->getMessage();
            $result['responseCode'] = Response::BAD_REQUEST . ' BAD REQUEST';
        }

        return $result;
    }

    /**
     * @param array $result
     */
    public function showResult(array $result): void
    {
        try {
            $view = new View($_SERVER['DOCUMENT_ROOT'] . '/../views/');
            $view->out('client', $result);
        } catch (MyException $exception) {
            echo $exception->getMessage().PHP_EOL;
        }
    }
}