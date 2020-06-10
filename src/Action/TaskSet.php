<?php

namespace App\Action;

use App\Domain\Task;
use App\Exception\HttpException;
use InvalidArgumentException;
use Laminas\Diactoros\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class TaskSet
{
    private Task $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function __invoke(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody()['data'] ?? null;
        if (!$data) {
            throw new HttpException(400);
        }
        try {
            return new Response\JsonResponse(
                [
                    'id' => $this->task->set($data),
                ]
            );
        } catch (InvalidArgumentException $e) {
            throw new HttpException(400);
        }
    }
}
