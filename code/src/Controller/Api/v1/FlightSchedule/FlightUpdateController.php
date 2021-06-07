<?php


namespace App\Controller\Api\v1\FlightSchedule;


use App\Entity\DTO\RequestDTO;
use App\Service\FlightSchedule\FlightScheduleServiceInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class FlightUpdateController extends AbstractFlightController
{
    /**
     *  Изменить рейс в расписании
     *
     * @OA\Put(
     *      path="/api/v1/flights",
     *      tags={"Расписание рейсов"},
     *      @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          example="Bearer c16e40fa31e1c99849c0",
     *          @OA\Schema(type="string"),
     *      ),
     *      @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(property="id", type="integer", description="ID рейса", example="10"),
     *                 @OA\Property(property="airline_id", type="integer", description="ID авиакомпании", example="1"),
     *                 @OA\Property(property="departure_id", type="integer", description="ID города вылета", example="2"),
     *                 @OA\Property(property="arrival_id", type="integer", description="ID города прилета", example="3"),
     *                 @OA\Property(property="departure_time", type="string", description="Дата и время вылета", example="2021-01-01T01:01:01+00:00")
     *             )
     *         )
     *      ),
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
