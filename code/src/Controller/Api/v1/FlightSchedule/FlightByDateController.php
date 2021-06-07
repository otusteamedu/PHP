<?php


namespace App\Controller\Api\v1\FlightSchedule;


use App\Entity\DTO\EntitiesDTO;
use App\Entity\DTO\NotFoundDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class FlightByDateController extends AbstractFlightController
{
    /**
     * Расписание рейсов на указанную дату
     *
     * @OA\Get(
     *      path="/api/v1/flights/{date}",
     *      tags={"Расписание рейсов"},
     *      @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          example="Bearer c16e40fa31e1c99849c0",
     *          @OA\Schema(type="string"),
     *      ),
     *     @OA\Parameter(
     *          name="Date",
     *          in="path",
     *          required=true,
     *          example="2021-02-03",
     *          @OA\Schema (type="string"),
     *     ),
     *     @OA\Response(
     *          response=200,
     *          description="Все записи",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/FlightSchedule")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Нет рейсов на указанную дату",
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
        $date = $args['date'];

        $flights = $this->flightScheduleService->findByDate($date);
        $data = $flights ? new EntitiesDTO($flights): new NotFoundDTO();

        return $this->jsonResponse($response, $data);
    }

}
