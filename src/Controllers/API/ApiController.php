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
        //Массив GET параметров разделенных слешем
        $this->requestUri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));
        $this->requestParams = $_REQUEST;

        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->formData = $this->getFormData($this->method);
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