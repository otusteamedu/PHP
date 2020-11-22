<?php

namespace App\Controllers\Api;

use App\Core\TaskSender;
use App\Views\ApiJsonView;
use JsonException;

class TaskApiController extends ApiController
{
    public string $apiName = 'task';
    protected ApiJsonView $apiJsonView;

    //соотносит метод запроса и действие в контроллере
    protected array $actionConfig = [
        'GET' => 'checkTaskAction',
        'POST' => 'createTaskAction',
        'DEFAULT' => 'wrongAction'
    ];

    public function __construct()
    {
        parent::__construct();
        $this->apiJsonView = new ApiJsonView();
    }

    /**
     * @throws JsonException
     */
    protected function checkTaskAction(): void
    {
        $this->apiJsonView->response('get ok', 200);
    }

    /**
     * @throws JsonException
     */
    protected function createTaskAction(): void
    {
        (new TaskSender())->newTask();
        $this->apiJsonView->response('post ok', 200);
    }

    /**
     * @throws JsonException
     */
    protected function wrongAction(): void
    {
        $this->apiJsonView->response('any ok', 405);
    }

}