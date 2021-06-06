<?php


namespace App\Controller\Api\v1\FlightSchedule;


use App\DTO\RequestDTO;
use App\Service\FlightSchedule\FlightScheduleServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class FlightDeleteController extends AbstractFlightController
{
    /**
     *  Удалить рейс из расписания
     *
     * @OA\Delete (
     *      path="/api/v1/flights/{id}",
     *      tags={"Расписание рейсов"},
     *      @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          example="Bearer c16e40fa31e1c99849c0",
     *          @OA\Schema(type="string"),
     *      ),
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="ID записи",
     *         example="22",
     *         @OA\Schema(type="integer")
     *     ),
     *      @OA\Response(
     *          response=200,
     *          description="Request",
     *          @OA\JsonContent(ref="#/components/schemas/RequestDTO"),
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Доступ запрещен",
     *          @OA\JsonContent(ref="#/components/schemas/ForbiddenDTO"),
     *     ),
     *  )
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $number = $this->requestService->addRequest($request, FlightScheduleServiceInterface::class);
        $data = new RequestDTO($number);

        return $this->jsonResponse($response, $data);
    }

}
