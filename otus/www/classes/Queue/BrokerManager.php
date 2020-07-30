<?php

namespace Classes\Queue;

use App\AppSettings;
use Classes\Dto\BrokerDto;
use Classes\Dto\BrokerDtoBuilder;
use Classes\Queue\Brokers\BrokersMap;


class BrokerManager
{
    private $config;

    public function __construct()
    {
        $this->config = include(AppSettings::CONFIG_QUEUE_PATH);
    }
    public function getBroker()
    {
        $brokers = $this->config['brokers'];
        $broker = $this->config['broker'];

        $brokerClass = BrokersMap::BROCKERS[$broker] ?? null;

        if ($brokerClass === null) {
            throw new \Exception('Нет подходящего брокера');
        }
        /** @var BrockerInterface $brokerObject */

        $brokerData = $brokers[$broker];

        if (!$brokerData) {
            throw new \Exception('Не найден конфиг для брокера');
        }
        $this->getConfigDto($brokerData, $broker);
        return new $brokerClass($this->getConfigDto($brokerData, $broker));
    }

    private function getConfigDto (array $brokerData, string $broker) : BrokerDto
    {
        $brokerBuilder = new BrokerDtoBuilder();
        return $brokerBuilder
            ->setBroker($broker)
            ->setHost($brokerData['host'])
            ->setPort($brokerData['port'])
            ->setUserName($brokerData['user'])
            ->setPassword($brokerData['password'])
            ->setQueueRequestName($brokerData['queue_request'])
            ->setQueueResponseName($brokerData['queue_response'])
            ->build();
    }
}
