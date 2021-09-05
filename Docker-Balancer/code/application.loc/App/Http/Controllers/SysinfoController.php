<?php

namespace App\Http\Controllers;


use App\Exceptions\Loader\ViewLoaderException;
use App\Http\Response\Helpers\StatusCodes;
use App\Http\Response\IResponse;
use App\Http\Response\Main\Response;
use App\Models\SysinfoModel;

/**
 * Контроллер маршрута /Sysinfo
 */
class SysinfoController extends BaseController
{

    /**
     * Модель
     * @var SysinfoModel
     */
    private SysinfoModel $model;


    /**
     * Конструктор класса
     */
    public function __construct(IResponse $response)
    {
        parent::__construct($response);
        $this->model = new SysinfoModel();
        $this->data['title'] = 'SysInfo checkers';
        $this->data['page_class'] = 'checker is-preload';
    }

    /**
     * Обработчик маршрута по умолчанию
     *
     * @throws ViewLoaderException
     */
    public function run(): void
    {
        $this->data += $this->model->getSysInfo();

        $this->loadView('Templates/header');
        $this->loadView('Sysinfo/header_sysinfo');
        $this->loadView('Sysinfo/server-ip');
        $this->loadView('Sysinfo/node-ip');
        $this->loadView('Sysinfo/sapi');
        $this->loadView('Sysinfo/sysinfo_footer');
        $this->loadView('Templates/footer');
    }

    /**
     * Обработчик маршрута Sysinfo/serverAddress
     *
     * @throws ViewLoaderException
     */
    public function serverAddress(): void
    {
        $this->data += $this->model->getSysInfo();

        $this->loadView('Templates/header');
        $this->loadView('Sysinfo/header_sysinfo');
        $this->loadView('Sysinfo/server-ip');
        $this->loadView('Sysinfo/sysinfo_footer');
        $this->loadView('Templates/footer');
    }

    /**
     * Обработчик маршрута Sysinfo/nodeAddress
     *
     * @throws ViewLoaderException
     */
    public function nodeAddress(): void
    {
        $this->data += $this->model->getSysInfo();

        $this->loadView('Templates/header');
        $this->loadView('Sysinfo/header_sysinfo');
        $this->loadView('Sysinfo/node-ip');
        $this->loadView('Sysinfo/sysinfo_footer');
        $this->loadView('Templates/footer');
    }

    /**
     * Обработчик маршрута Sysinfo/sapi
     *
     * @throws ViewLoaderException
     */
    public function sapi(): void
    {
        $this->data += $this->model->getSysInfo();

        $this->loadView('Templates/header');
        $this->loadView('Sysinfo/header_sysinfo');
        $this->loadView('Sysinfo/sapi');
        $this->loadView('Sysinfo/sysinfo_footer');
        $this->loadView('Templates/footer');
    }

    /**
     * Метод вызываемый из клиента.
     * Возвращает Ip адрес webserver-а
     */
    public function xhrGetServerAddress() {
        $result = $this->model->getServerAddress();
        $result['title'] = 'Server Address';
        $this->response->send(StatusCodes::OK, 'sysinfo', $result);
    }

    /**
     * Метод вызываемый из клиента.
     * Возвращает Ip адрес PHP ноды
     */
    public function xhrGetNodeAddress() {
        $result = $this->model->getNodeAddress();
        $result['title'] = 'Node Ip';
        $this->response->send(StatusCodes::OK, 'sysinfo', $result);
    }

    /**
     * Метод вызываемый из клиента.
     * Возвращает Ip адрес webserver-а
     */
    public function xhrGetSapi() {
        $result = $this->model->getSapi();
        $result['title'] = 'Интерфейс между веб-сервером и PHP';
        $this->response->send(StatusCodes::OK, 'sysinfo', $result);
    }

    /**
     * Метод вызываемый из клиента.
     * Возвращает Ip адрес webserver-а
     */
    public function xhrGetInfo() {
        $result = $this->model->getSysInfo();
        $this->response->send(StatusCodes::OK, 'sysinfo', $result);
    }
}