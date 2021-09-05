<?php

namespace App\Http\Controllers;

use App\Exceptions\Loader\ViewLoaderException;
use App\Helpers\AppConst;
use App\Http\Response\Checker\CheckerResponse;
use App\Http\Response\Checker\ErrorResponse;
use App\Http\Response\Helpers\StatusCodes;
use App\Http\Response\IResponse;
use App\Http\Response\ResponseXhr;
use Resources\Views\ViewsLoader;

/**
 * Базовый контроллер
 */
abstract class BaseController
{
    const VIEW_BASE_PATH = 'resources/Views/';

    /**
     * Массив данных передаваемых во View
     * @var array
     */
    protected array $data = [];

    /**
     * Базовый каталог для Вьюшек
     * @var string|mixed
     */
    protected string $viewBasePath;

    /**
     * параметры из запроса
     * @var array
     */
    protected array $parameters;

    /**
     * Title контроллера
     * @var string
     */
    protected string $title = '';

    /**
     * Текст ответа (без данных)
     * @var string
     */
    protected string $responseMsg = '';

    /**
     * Тип ответа
     * @var IResponse
     */
    protected IResponse $response;


    /**
     * Конструктор класса
     */
    public function __construct(IResponse $response)
    {
        $this->response = $response;
        $this->viewBasePath = $_ENV['VIEW_BASE_PATH'] ?? self::VIEW_BASE_PATH;
        $this->data['memcachedCluster'] = $_ENV['MEMCACHED_CLUSTER'] ?? 0;
    }

    /**
     * Загружает View для контроллера.
     *
     * @param string $viewName
     * @throws ViewLoaderException
     */
    protected function loadView(string $viewName = ''): void
    {
        if (empty($viewName)) {
            $viewName = $this->getCurrentControllerName() . '/' . $_ENV['DEFAULT_VIEW_NAME'];
        }
        $path = $_SERVER['DOCUMENT_ROOT'] . '/' . $this->viewBasePath;
        $app = new ViewsLoader($this->data);
        $app->load($path . '/' . $viewName . '.php');
    }

    /**
     * Возвращает параметры пришедшие в запросе
     *
     * @return array
     */
    protected function getParameters(): array
    {
        return $this->parameters = $_REQUEST ?? [];
    }

    /**
     * Возвращает имя текущего контроллеру
     *
     * @return string
     */
    private function getCurrentControllerName(): string
    {
        $controller = explode('\\', get_class($this));
        return str_replace(
            'Controller',
            '',
            array_pop($controller)
        );
    }

    /**
     *
     * @param array $result
     */
    protected function xhrSendCheckerResult(array $result): void
    {
        if ($result['status'] === AppConst::ERROR_CONNECTED) {
            $this->response->send($result['error']['code'] ?? 0, $this->responseMsg, ['title' => $this->title, 'error' => $result['error']]);
        }
        if ($result['status'] === AppConst::SERVER_CONNECTED) {
            $this->response->send(StatusCodes::OK, $this->responseMsg, ['title' => $this->title, 'info' => $result]);
        }
    }
}