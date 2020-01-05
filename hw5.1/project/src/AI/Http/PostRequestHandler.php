<?php

namespace AI\backend_php_hw5_1\Http;


use AI\backend_php_hw5_1\Exceptions\HttpReponseException;
use AI\backend_php_hw5_1\Exceptions\HttpRequestException;
use AI\backend_php_hw5_1\Http\Response;

class PostRequestHandler
{
    /**
     * @var string
     */
    private string $url;


    /**
     * Поля POST-запроса преобразованные в url-закодированную строку
     * вида 'para1=val1&para2=val2&...'
     *
     * @var string
     */
    private string $fields;

    public function __construct(string $url, array $params)
    {
        $this->url = $url;

        /**
         * Преобразование делается для соблюдения условия ДЗ:
         * Content-Type: application/x-www-form-urlencoded
         */
        $this->fields = http_build_query($params);
    }

    /**
     * @return string
     *
     * @throws HttpReponseException
     * @throws HttpRequestException
     */
    public function proceed(): string
    {
        $curlHandler = curl_init($this->url);
        if ($curlHandler === false) {
            throw new HttpRequestException('Ошибка инициализации сеанса с cURL');
        }

        curl_setopt($curlHandler, CURLOPT_POST, true);
        curl_setopt($curlHandler, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curlHandler, CURLOPT_POSTFIELDS, $this->fields);

        $result = curl_exec($curlHandler);
        if ($result === false) {
            throw new HttpRequestException('Произошла ошибка в ходе выполнения POST запроса');
        }

        $info = curl_getinfo($curlHandler);
        curl_close($curlHandler);

        if ($info['http_code'] == Response::BAD_REQUEST) {
            throw new HttpReponseException($result);
        }

        return $result;
    }
}
