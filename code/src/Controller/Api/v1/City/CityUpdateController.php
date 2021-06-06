<?php


namespace App\Controller\Api\v1\City;



use App\DTO\BadRequestDTO;
use App\DTO\SuccessDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

final class CityUpdateController extends AbstractCityController
{
    /**
     * Изменить город
     *
     * @OA\Put(
     *      path="/api/v1/cities",
     *      tags={"Города"},
     *      @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          example="Bearer c16e40fa31e1c99849c0",
     *          @OA\Schema(type="string"),
     *      ),
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="id", type="integer", description="ID города", example="123"),
     *                  @OA\Property(property="name", type="string", description="Название город", example="Тамбов"),
     *              ),
     *          ),
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
     *          description="Город не найден",
     *          @OA\JsonContent(ref="#/components/schemas/NotFoundDTO"),
     *      ),
     *  )
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $result = $this->cityService->update($data);

        $data =  $result ? new SuccessDTO() : new BadRequestDTO();

        return $this->jsonResponse($response, $data);
    }

}
