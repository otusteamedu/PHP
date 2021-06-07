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


    /**
     * Информация о состоянии запроса
     *
     * @OA\Get(
     *      path="/api/v1/request-status/{request_number}",
     *      tags={"Запросы"},
     *      @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          example="Bearer c16e40fa31e1c99849c0",
     *          @OA\Schema(type="string"),
     *      ),
     *      @OA\Parameter(
     *         name="request_number",
     *         in="query",
     *         description="Номер запроса",
     *         example="22",
     *         @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Запрос",
     *          @OA\JsonContent(ref="#/components/schemas/Request"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Город не найден",
     *          @OA\JsonContent(ref="#/components/schemas/NotFoundDTO")
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Доступ запрещен",
     *          @OA\JsonContent(ref="#/components/schemas/ForbiddenDTO"),
     *     ),
     *  )
     */
    public function __invoke(Request $request, Response $response, $args): Response
    {
        $number = (int) $args['request_number'];

        $status = $this->requestService->getRequestStatus($number);

        $data = $status ? new EntityDTO($status) : new NotFoundDTO();

        return $this->jsonResponse($response, $data);
    }


}
