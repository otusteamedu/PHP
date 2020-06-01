<?php

namespace HW5;

/**
 * Class BracketsChecker
 * @package HW5
 */
class BracketsChecker
{
    private $method;
    private $requestUri;
    private $requestParams;

    private $action;

    private $paramNameToCheck = 'string';

    const BRACKETS_REGEXP = "/^((?>[^()]|\((?1)\))*)$/m";

    public function __construct()
    {
        $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
        $this->requestParams = $_REQUEST;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->checkContentLength();
    }

    /**
     * Запуск обработчика запроса к сервису
     *
     * @return mixed
     * @throws HttpException
     */
    public function run()
    {
        $this->action = $this->getAction();

        if (method_exists($this, $this->action)) {
            return $this->{$this->action}();
        } else {
            throw new HttpException('Invalid Method', 405);
        }
    }

    /**
     * Проверка строки из запроса
     *
     * @throws HttpException
     */
    private function checkString(): void
    {
        $string = $this->requestParams[$this->paramNameToCheck];
        $this->checkParam($string);

        if (preg_match_all(self::BRACKETS_REGEXP, $string))
        {
            $this->successResponse();
        } else {
            throw new HttpException('Brackets sequence is not valid', 400);
        }
    }

    private function checkContentLength(): void
    {
        $contentLength = $_SERVER['CONTENT_LENGTH'];

        if ($contentLength <= 0) {
            throw new HttpException('Content-length required', 411);
        }

        $request = urldecode(http_build_query($_POST));
        $size = strlen($request);

        if ($contentLength != $size)
        {
            throw new HttpException('Wrong Content-length', 400);
        }
    }

    private function successResponse()
    {
        http_response_code(200);
        echo 'Brackets sequence is valid';
    }

    /**
     * Проверка параметра на непустоту
     *
     * @param string|null $param
     * @throws HttpException
     */
    private function checkParam(?string $param = ''): void
    {
        if (!isset($param)) {
            throw new HttpException('No parameters to check', 400);
        }
        if (empty($param)) {
            throw new HttpException('String parameters is empty', 400);
        }
    }

    /**
     * Получение подходящего метода по запросу
     *
     * @return string|null
     */
    private function getAction(): ?string
    {
        $method = $this->method;
        switch ($method) {
            case 'POST':
                return 'checkString';
                break;
            default:
                return null;
        }
    }
}