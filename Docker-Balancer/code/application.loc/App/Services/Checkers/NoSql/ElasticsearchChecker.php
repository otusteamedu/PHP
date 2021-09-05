<?php

namespace App\Services\Checkers\NoSql;


use App\Exceptions\Connection\InvalidArgumentException;
use App\Helpers\AppConst;
use App\Services\Checkers\AbstractChecker;
use Elasticsearch\Client;
use Src\Database\Connectors\ConnectorsFactory;


class ElasticsearchChecker extends AbstractChecker
{
    /**
     * @var array
     */
    private array $config;


    /**
     * Конструктор класса
     *
     * @param array $connectionConfig
     */
    public function __construct(array $connectionConfig = [])
    {
        $this->config = $connectionConfig;
    }

    /**
     * Запускает проверку
     *
     * @return ElasticsearchChecker
     * @throws InvalidArgumentException
     */
    public function check(): self
    {
        $elastic = $this->connect();
        $info = $elastic->info();
        $this->info = [
            'status' => AppConst::SERVER_CONNECTED,
            'serverInfo' => $this->layoutInfo($info)
        ];
        return $this;
    }

    /**
     * @return Mixed
     * @throws InvalidArgumentException
     */
    private function connect(): Client
    {
        return ConnectorsFactory::createConnection($_ENV['ELASTICSEARCH_DRIVER'], $this->config)->connect();
    }

    /**
     * Верстка Блока Info
     *
     * @param array $rows
     * @return string
     */
    private function layoutInfo(array $rows): string
    {
        $str = '';
        foreach ($rows as $row => $value) {
            $str .= (is_array($value))
                ? "<b style='color: #096e00'>$row:" . $this->layoutInfo($value) . "</b>"
                : "<p>" . $row . ": " . $value . "</p>";
        }
        return $str;
    }
}