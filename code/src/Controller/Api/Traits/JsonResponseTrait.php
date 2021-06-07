<?php


namespace App\Controller\Api\Traits;



use App\Entity\DTO\InterfaceDTO;
use Psr\Http\Message\ResponseInterface;

trait JsonResponseTrait
{
    protected function jsonResponse(ResponseInterface $response, InterfaceDTO $dto): ResponseInterface
    {
        $response->getBody()->write(json_encode($dto));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($dto->getStatusCode());
    }
}
