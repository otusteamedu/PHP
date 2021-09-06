<?php

namespace Src\Database\Connectors;


use App\Exceptions\Connection\CannotConnectElasticsearchException;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Elasticsearch\Common\Exceptions\InvalidArgumentException;
use Exception;


class ElasticsearchConnector extends Connector implements IConnector
{
    const DSN = 'elasticsearch';

    public function __construct(array $config)
    {
        $this->config = $config;
        parent::__construct();
    }


    /**
     * Устанавливает соединение с базой данных
     *
     * @return Client
     * @throws CannotConnectElasticsearchException
     */
    public function connect(): Client
    {
        try {
            $hosts = [
                $this->host.":".$this->port,  // Domain + Port
                //'192.168.1.1:9200',         // IP + Port
                //'192.168.1.2',              // Just IP
                //'mydomain2.server.com',     // Just Domain
                //'https://localhost',        // SSL to localhost
                //'https://192.168.1.3:9200'  // SSL to IP + Port
            ];
            $connect = ClientBuilder::create()           // Instantiate a new ClientBuilder
            ->setHosts($hosts)      // Set the hosts
            ->build();
            // вызывается метод info, который вызывает ошибку, если не удалось подключить сервер
            $connect->info();
            return $connect;
        } catch (Exception $ex) {
            throw new CannotConnectElasticsearchException($ex->getMessage(), $ex->getCode());
        }
    }
}