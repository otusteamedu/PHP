<?php


namespace Otushw\ServerQueue\Jobs;

use Otushw\DTOs\OrderDTO;
use Otushw\Helper;
use Otushw\Logger\AppLogger;
use Otushw\Models\Query;
use PDO;
use Otushw\Storage\DBConnection;
use Otushw\Models\Order;
use Otushw\Storage\Query\QueryMapper;

class Worker
{
    const ALLOWED_COMMANDS = ['update', 'create', 'delete'];
    const REQUIRED_PARAM = ['id_query', 'command', 'data'];

    protected PDO $pdo;
    protected int $queryID;
    protected string $command;
    private array $data;

    public function __construct(string $message)
    {
        $this->pdo = DBConnection::getInstance();

        $this->validate($message);

        $data = json_decode($message, true);
        $this->command = $data['command'];
        $this->queryID = $data['id_query'];
        $this->data = $data['data'];
    }

    public function create(): Job
    {
        switch ($this->command) {
            case 'update':
                $order = new Order(
                    $this->data['id'],
                    $this->data['productName'],
                    $this->data['quantity'],
                    $this->data['total']
                );
                $job = new JobUpdate($order);
                break;
            case 'create':
                $orderRaw = new OrderDTO(
                    1,
                    $this->data['productName'],
                    $this->data['quantity'],
                    $this->data['total']
                );
                $job = new JobCreate($orderRaw);
                break;
            case 'delete':
                $job = new JobDelete($this->data['id']);
                break;
            default:
                //         \Exception::
                break;
        }
        AppLogger::addInfo('RabbitMQ:Consumer create job - ' . $this->command);
        return $job;
    }

    public function finish()
    {
        $mapper = new QueryMapper($this->pdo);
        $mapper->update(new Query($this->queryID, Query::STATUS_END));
    }

    private function validate(string $message)
    {
        if (!Helper::isJSON($message)) {
            // return null/ Exception
        }
        $data = json_decode($message, true);
        foreach (self::REQUIRED_PARAM as $item) {
            if (empty($data[$item])) {
//            return Exceprtion
            }
        }

        if (!in_array($data['command'], self::ALLOWED_COMMANDS)) {
//            return Exceprtion
        }
    }
}