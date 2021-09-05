<?php

namespace App\Http\Controllers;


use App\Exceptions\Loader\ViewLoaderException;
use App\Http\Response\IResponse;
use App\Models\SysinfoModel;

/**
 * Контроллер по умолчанию.
 */
class DefaultController extends BaseController
{
    /**
     * @var SysinfoModel
     */
    private SysinfoModel $sysinfoModel;

    /**
     * Конструктор класса
     */
    public function __construct(IResponse $response)
    {
        parent::__construct($response);
        $this->sysinfoModel = new SysinfoModel();
    }


    /**
     * Обработчик маршрута по умолчанию
     *
     * @throws ViewLoaderException
     */
    public function run(): void
    {
        $this->data['title'] = 'Docker containers checker';
        $this->data['memcachedCluster'] = $_ENV['MEMCACHED_CLUSTER'] ?? false;
        $this->data['sapi'] = $this->sysinfoModel->getSapi();
        $this->data['serverIp'] = $this->sysinfoModel->getServerAddress();
        $this->data['nodeIp'] = $this->sysinfoModel->getNodeAddress();
        $this->data['page_class'] = 'homepage is-preload';

        $this->loadView('Default/index');
        $this->loadView('Templates/footer');
    }
}