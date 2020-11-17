<?php

namespace App\Controllers\Api;

use Exception;
use RuntimeException;

abstract class ApiController
{
    public string $apiName = '';
    public string $formData = ''; //Хранит данные из body

    public array $requestUri = [];
    public array $requestParams = [];

    protected string $method = '';
    protected string $action = ''; //Название метода для выполнения

    //соотносит метод запроса и действие в контроллере
    protected array $actionConfig = [
        'GET' => 'indexAction',
        'POST' => 'createAction',
        'PUT' => 'updateAction',
        'DELETE' => 'deleteAction',
        'DEFAULT' => 'indexAction'
    ];

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
        $this->formData = $this->getFormData();
    }

    /**
     * @return array|false|string
     */
    protected function getFormData()
    {
        return file_get_contents('php://input');
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
        if (array_key_exists($this->method, $this->actionConfig)) {
            return $this->actionConfig[$this->method];
        }

        return $this->actionConfig['DEFAULT'];
    }
}