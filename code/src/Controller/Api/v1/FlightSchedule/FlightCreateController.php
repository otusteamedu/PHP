<?php


namespace App\Controller\Api\v1\FlightSchedule;


use App\DTO\EntitiesDTO;
use App\DTO\NotFoundDTO;
use App\DTO\RequestDTO;
use App\Entity\FlightSchedule;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class FlightCreateController extends AbstractFlightController
{
    /**
     *  Добавить рейс в расписание
     *
     * @OA\Post(
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
     *                 @OA\Property(property="airline", type="string", description="Название авиакомпании", example="Аэроком"),
     *                 @OA\Property(property="departure", type="string", description="Город вылета", example="Москва"),
     *                 @OA\Property(property="arrival", type="string", description="Город прилета", example="Амстердам"),
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
        $number = $this->requestService->addRequest($request, FlightSchedule::class);
        $data = new RequestDTO($number);

        return $this->jsonResponse($response, $data);
    }

}
