<?php


namespace Repetitor8\Application\Routers\Queue;


use Repetitor8\Application\Routers\Router;
use Repetitor8\Domain\Services\Queue\QueueService;
use Repetitor8\Application\Routers\IRouter;

class QueueRouter implements IRouter
{
    private const TYPE_RECEIVE = 'receive';
    private const TYPE_SEND = 'send';

    public static function run(int $argvNumber = 1): void
    {
        $service = new QueueService();
        $argv = Router::getArgv($argvNumber);

        switch ($argv) {
            case self::TYPE_RECEIVE:
                $service->receive();
                break;
            case self::TYPE_SEND:
                if (isset($_POST) && isset($_POST['message'])) {
                    $message = $_POST['message'];
                } else {
                    throw (new \Exception('POST-request must have message!'));
                }
                $service->send($message);
                break;
            default:
                throw (new \Exception('Undefined argv!'));
        }
    }
}