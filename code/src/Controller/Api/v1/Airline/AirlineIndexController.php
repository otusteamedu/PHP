<?php


namespace App\Controller\Api\v1\Airline;


use App\Entity\DTO\EntitiesDTO;
use App\Entity\DTO\NotFoundDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class AirlineIndexController extends AbstractAirlineController
{
    /**
     * Список авиакомпаний
     *
     * @OA\Get(
     *      path="/api/v1/airlines",
     *      tags={"Авиакомпании"},
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
     *          description="Список авиакомпаний",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/Airline")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Авиакомпании не найдены",
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

        $airlines = $this->airlineService->getAll($limit, $offset);
        $data = $airlines ? new EntitiesDTO($airlines): new NotFoundDTO();

        return $this->jsonResponse($response, $data);
    }

}
