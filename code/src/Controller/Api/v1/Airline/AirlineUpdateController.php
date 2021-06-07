<?php


namespace App\Controller\Api\v1\Airline;


use App\Entity\DTO\BadRequestDTO;
use App\Entity\DTO\SuccessDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AirlineUpdateController extends AbstractAirlineController
{

    /**
     * Изменить авиакомпанию
     *
     * @OA\Put(
     *      path="/api/v1/airlines",
     *      tags={"Авиакомпании"},
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
     *                 @OA\Property(property="id", type="integer", description="ID авиакомпании", example="123"),
     *                 @OA\Property(property="title", type="string", description="Название авиакомпании", example="Аэроком"),
     *                 @OA\Property(property="description", type="string", description="Описание компании", example="Аэроком лучшая компания"),
     *                 @OA\Property(property="abbreviation", type="string", description="Аббревиатура компании", example="AEK"),
     *             ),
     *         ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(ref="#/components/schemas/SuccessDTO"),
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
     *      @OA\Response(
     *          response=404,
     *          description="Авиакомпания не найдена",
     *          @OA\JsonContent(ref="#/components/schemas/NotFoundDTO"),
     *      ),
     *  )
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $result = $this->airlineService->update($data);

        $data =  $result ? new SuccessDTO() : new BadRequestDTO();

        return $this->jsonResponse($response, $data);
    }

}
