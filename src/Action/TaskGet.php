<?php

namespace App\Action;

use App\Domain\Task;
use App\Exception\HttpException;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TaskGet
{
    private Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $id = $request->getParsedBody()['id'] ?? null;
        if (!is_string($id)) {
            throw new HttpException(400);
        }
        return new Response\JsonResponse($this->task->get($id));
    }
}
