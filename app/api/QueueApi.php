<?php


namespace nvggit\hw26\api;


use nvggit\hw26\App;
use nvggit\hw26\models\Task;
use nvggit\hw26\rabbit\RabbitClient;

class QueueApi extends RestApi
{
    public $apiName = 'queue';

    /**
     * Type GET
     * Get Task status
     * http://domain/queue/correlation_id
     *
     * @return false|string
     */
    public function viewAction()
    {
        $id = array_shift($this->requestUri);

        if (isset(App::getInstance()[$id])) {
            return $this->response(App::getInstance()[$id], 200);
        }
        return $this->response('Data not found', 404);
    }

    /**
     * Type POST
     * Add new Task
     * http://domain/queue
     *
     * @return false|string
     * @throws \Exception
     */
    public function createAction()
    {
        $clientTask = new RabbitClient(Task::TYPE_FROG_HARD_WORK);

        $task = new Task();
        $task->status = Task::STATUS_NEW;
        $task->type = Task::TYPE_FROG_HARD_WORK;

        $correlation_id = $clientTask->addTask($task);

        return $this->response('Task added, correlation_id ' . $correlation_id, 200);
    }
}