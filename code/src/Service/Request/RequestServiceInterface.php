<?php


namespace App\Service\Request;


use Psr\Http\Message\ServerRequestInterface;

interface RequestServiceInterface
{
    public function getRequestStatus(int $number): ?\JsonSerializable;
    public function addRequest(ServerRequestInterface $request, string $entity): int;
}
