<?php


namespace Services;


use Classes\Dto\PushDto;

interface BrokerServiceInterface
{
    public function pushRequest(PushDto $pushDto): string;

    public function getRequestStatusById(string $id): string;

    public function popRequest();

    public function pushResponse(string $response);

    public function handleRequest();
}
