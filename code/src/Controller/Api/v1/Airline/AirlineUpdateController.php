<?php


namespace App\Controller\Api\v1\Airline;


use App\Controller\Api\AbstractController;
use App\DTO\BadRequestDTO;
use App\DTO\SuccessDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AirlineUpdateController extends AbstractController
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
     *          description="Авиакомппания",
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Airline"),
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
