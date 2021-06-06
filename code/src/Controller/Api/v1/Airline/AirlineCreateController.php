<?php


namespace App\Controller\Api\v1\Airline;


use App\DTO\BadRequestDTO;
use App\DTO\EntityDTO;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AirlineCreateController extends AbstractAirlineController
{
    /**
     * Добавить авиакомпанию
     *
     * @OA\Post(
     *      path="/api/v1/airlines",
     *      tags={"Авиакомпании"},
     *      description="",
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
     *                 @OA\Property(property="title", type="string", description="Название авиакомпании", example="Аэроком"),
     *                 @OA\Property(property="description", type="string", description="Описание компании", example="Аэроком лучшая компания"),
     *                 @OA\Property(property="abbreviation", type="string", description="Аббревиатура компании", example="AEK")
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Авиакомпания",
     *          @OA\JsonContent(ref="#/components/schemas/Airline"),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Неверные данные",
     *          @OA\JsonContent(ref="#/components/schemas/BadRequestDTO"),
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
        $data = $request->getParsedBody();
        $result = $this->airlineService->create($data);

        $data = $result
            ? new EntityDTO($result, StatusCodeInterface::STATUS_CREATED)
            : new BadRequestDTO();

        return $this->jsonResponse($response, $data);
    }

}
