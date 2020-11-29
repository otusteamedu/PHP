<?php

namespace App\Controllers\Api;

use App\Core\Task;
use App\Views\ApiJsonView;
use Exception;
use JsonException;


/**
 * Class TaskApiController
 * @package App\Controllers\Api
 * @OA\Info(
 *     title="Otus tasks queue API",
 *     version="1.0",
 *   @OA\Contact(
 *     email="gluskov1997@icloud.com"
 *   )
 * )
 */
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
     * @OA\Get(
     *   path="/api/task/[ID task]",
     *   summary="Get task status by ID",
     *   @OA\Response(
     *     response=404,
     *     description="Task not found"
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="Return task status by ID"
     *   )
     * )
     * @throws JsonException
     */
    protected function checkTaskAction(): void
    {
        if (isset($this->requestUri[2])) {
            $status = $this->task->getTaskStatus((int)$this->requestUri[2]);
            $this->apiJsonView->response($status, 200);
        } else {
            $this->apiJsonView->response('Tasks ID not found', 404);
        }
    }

    /**
     * @throws JsonException
     * @throws Exception
     * @OA\Post(
     *     path="/api/task",
     *     @OA\Response(
     *       response="200",
     *       description="Your task is create. You need to copy your tasks ID"
     *     )
     * )
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