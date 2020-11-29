<?php

namespace App\Controllers\Api;

use App\Core\Task;
use App\Views\ApiJsonView;
use Exception;
use JsonException;

class TaskApiController extends ApiController
{
    public string $apiName = 'task';
    protected ApiJsonView $apiJsonView;
    protected array $actionConfig = [
        'GET' => 'checkTaskAction',
        'POST' => 'createTaskAction',
        'DEFAULT' => 'wrongAction'
    ];

    //соотносит метод запроса и действие в контроллере
    private Task $task;

    public function __construct()
    {
        parent::__construct();
        $this->apiJsonView = new ApiJsonView();
        $this->task = new Task();
    }

    /**
     * @throws JsonException
     */
    protected function checkTaskAction(): void
    {
        $status = $this->task->getTaskStatus((int)$this->requestUri[2]);
        $this->apiJsonView->response($status, 200);
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    protected function createTaskAction(): void
    {
        $taskID = $this->task->newTask();
        $this->apiJsonView->response('Your task is create. Tasks ID is ' . $taskID, 200);
    }

    /**
     * @throws JsonException
     */
    protected function wrongAction(): void
    {
        $this->apiJsonView->response('This method is not use!', 405);
    }

}