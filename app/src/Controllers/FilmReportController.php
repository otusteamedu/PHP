<?php


namespace App\Controllers;

use App\Services\RabbitMQ\EventDispatcher;
use App\Services\RabbitMQ\Publishers\ReportPublisher;
use App\Services\ServiceContainer\AppServiceContainer;
use JsonException;
use PhpAmqpLib\Message\AMQPMessage;

class FilmReportController extends BaseController
{
    private EventDispatcher $eventDispatcher;

    public function __construct()
    {
        $this->eventDispatcher = AppServiceContainer::getInstance()->resolve(EventDispatcher::class);
    }

    public function show(): string
    {
        $this->title = 'Films Report Form';

        $this->content = $this->renderView('pages.films.get-report-form');

        return $this->viewResponse();
    }

    /**
     * @throws JsonException
     */
    public function store(): string
    {
        $request = $this->getRequest();

        $this->eventDispatcher->dispatch(
            ReportPublisher::class,
            new AMQPMessage(json_encode([
                'email' => $request->get('email'),
            ], JSON_THROW_ON_ERROR))
        );

        return $this->redirect('films/report/success');
    }

    public function success(): string
    {
        $this->title = 'Films Report in Processing';

        $this->content = $this->renderView('pages.films.report-success');

        return $this->viewResponse();
    }
}