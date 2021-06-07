<?php


namespace App\Controller\Api\v1\City;


use App\Entity\DTO\BadRequestDTO;
use App\Entity\DTO\EntityDTO;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class CityCreateController extends AbstractCityController
{
    /**
     * Добавить город
     *
     * @OA\Post(
     *      path="/api/v1/city",
     *      tags={"Города"},
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
     *                 @OA\Property(property="name", type="string", description="Название город", example="Тамбов"),
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Город",
     *          @OA\JsonContent(ref="#/components/schemas/City"),
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
        $result = $this->cityService->create($data);

        $data = $result
            ? new EntityDTO($result, StatusCodeInterface::STATUS_CREATED)
            : new BadRequestDTO();

        return $this->jsonResponse($response, $data);
    }

}
