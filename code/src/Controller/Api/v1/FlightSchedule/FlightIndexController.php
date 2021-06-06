<?php


namespace App\Controller\Api\v1\FlightSchedule;


use App\DTO\EntitiesDTO;
use App\DTO\NotFoundDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class FlightIndexController extends AbstractFlightController
{
    /**
     * Расписание рейсов
     *
     * @OA\Get(
     *      path="/api/v1/flights",
     *      tags={"Расписание рейсов"},
     *      @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          example="Bearer c16e40fa31e1c99849c0",
     *          @OA\Schema(type="string"),
     *      ),
     *      @OA\Parameter(
     *          name="limit",
     *          in="query",
     *          description="Лимит записей",
     *          example="10",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Parameter(
     *          name="offset",
     *          in="query",
     *          description="Смещение от начала записей",
     *          example="2",
     *          @OA\Schema(type="integer")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Все записи",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/City")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Рассписаний нет",
     *          @OA\JsonContent(ref="#/components/schemas/NotFoundDTO")
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
        list ($limit, $offset) = array_values($request->getQueryParams());

        $flights = $this->flightScheduleService->getAll($limit, $offset);
        $data = $flights ? new EntitiesDTO($flights): new NotFoundDTO();

        return $this->jsonResponse($response, $data);
    }

}
