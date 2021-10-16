<?php

namespace App\Http\Controllers;


use App\Exceptions\ErrorCodes;
use App\Exceptions\Loader\ViewLoaderException;
use App\Http\Response\Helpers\StatusCodes;
use App\Http\Response\IResponse;
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
     * @param IResponse $response
     */
    public function __construct(IResponse $response)
    {
        $this->response = $response;
        $this->viewBasePath = $_ENV['VIEW_BASE_PATH'] ?? self::VIEW_BASE_PATH;
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
        return str_replace(
            'Controller',
            '',
            (new \ReflectionClass($this))->getShortName()
        );
        return (new \ReflectionClass($this))->getShortName();
    }

    /**
     *
     * @param array $result
     */
    protected function xhrSendResult(array $result): void
    {
        $this->response->send(StatusCodes::OK, $this->responseMsg, ['title' => $this->title, 'info' => $result]);
    }
}