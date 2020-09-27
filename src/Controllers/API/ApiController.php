<?php

namespace Controllers\API;

use Exception;
use JsonException;
use RuntimeException;

abstract class ApiController
{
    public string $apiName = '';

    protected string $method = ''; //GET|POST|PUT|DELETE

    public array $requestUri = [];
    public array $requestParams = [];

    protected string $action = ''; //Название метод для выполнения

    public array $formData = []; //Хранит данные из body

    /**
     * ApiController constructor.
     * @throws Exception
     */
    public function __construct()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: *");
        header("Content-Type: application/json");

        //Массив GET параметров разделенных слешем
        $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $this->requestParams = $_REQUEST;

        //Определение метода запроса
        $this->method = $_SERVER['REQUEST_METHOD'];

        switch ($this->method) {
            case 'POST':
            case 'DELETE':
            case 'PUT':
            case 'GET':
                $this->formData = $this->getFormData($this->method);
                break;
            default:
                throw new RuntimeException("Unexpected Header");
        }
    }

    public function run()
    {
        //Первые 2 элемента массива URI должны быть "api" и название таблицы
        if (array_shift($this->requestUri) !== 'api' || array_shift($this->requestUri) !== $this->apiName) {
            throw new RuntimeException('API Not Found', 404);
        }
        //Определение действия для обработки
        $this->action = $this->getAction();

        //Если метод(действие) определен в дочернем классе API
        if (method_exists($this, $this->action)) {
            return $this->{$this->action}();
        }

        throw new RuntimeException('Invalid Method', 405);
    }

    /**
     * @param $data
     * @param int $status
     * @return false|string
     * @throws JsonException
     */
    protected function response($data, $status = 500)
    {
        header("HTTP/1.1 " . $status . " " . $this->requestStatus($status));
        return json_encode($data, JSON_THROW_ON_ERROR);
    }

    private function requestStatus($code): string
    {
        $status = array(
            200 => 'OK',
            404 => 'Not Found',
            405 => 'Method Not Allowed',
            500 => 'Internal Server Error',
        );
        return ($status[$code]) ?: $status[500];
    }

    protected function getAction(): string
    {
        $method = $this->method;
        switch ($method) {
            case 'GET':
                if ($this->requestUri) {
                    return 'viewAction';
                }
                return 'indexAction';
            case 'POST':
                return 'createAction';
            case 'PUT':
                return 'updateAction';
            case 'DELETE':
                return 'deleteAction';
            default:
                return '';
        }
    }

    /**
     * @param $method
     * @return array
     * @throws JsonException
     */
    protected function getFormData($method): array
    {
        if ($method === 'GET') {
            return $_GET;
        }

        $inputJSON = file_get_contents('php://input');
        return json_decode($inputJSON, TRUE, 512, JSON_THROW_ON_ERROR);
    }

    //все записи
    abstract protected function indexAction();

    //одна запись по id
    abstract protected function viewAction();

    //post на создание записи
    abstract protected function createAction();

    //получить запись по условиям
    abstract protected function updateAction();

    //удалить все записи
    abstract protected function deleteAction();
}