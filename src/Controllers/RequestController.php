<?php

namespace Bjlag\Controllers;

use Bjlag\BaseController;
use Bjlag\Models\Event;
use League\Route\Http\Exception\BadRequestException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class RequestController extends BaseController
{
    /**
     * Обработка запроса пользователя.
     * Получить подходящее событие.
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \League\Route\Http\Exception\BadRequestException
     */
    public function findEventAction(ServerRequestInterface $request): ResponseInterface
    {
        $data = $request->getParsedBody();

        $params = $data['params'] ?? null;
        if ($params === null || !is_array($params)) {
            throw new BadRequestException('Запрос не содержит параметры события.');
        }

        return $this->getResponseJson(Event::findByParams($params));
    }
}
