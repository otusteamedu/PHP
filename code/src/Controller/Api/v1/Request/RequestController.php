<?php


namespace App\Controller\Api\v1\Request;


use App\Controller\Api\Traits\JsonResponseTrait;
use App\DTO\EntityDTO;
use App\DTO\NotFoundDTO;
use App\Service\Request\RequestServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class RequestController
{
    use JsonResponseTrait;

    private RequestServiceInterface $requestService;

    /**
     * RequestController constructor.
     * @param \App\Service\Request\RequestServiceInterface $requestService
     */
    public function __construct(RequestServiceInterface $requestService)
    {
        $this->requestService = $requestService;
    }

    public function __invoke(Request $request, Response $response, $args): Response
    {
        $number = (int) $args['request_number'];

        $status = $this->requestService->getRequestStatus($number);

        $data = $status ? new EntityDTO($status) : new NotFoundDTO();

        return $this->jsonResponse($response, $data);
    }


}
