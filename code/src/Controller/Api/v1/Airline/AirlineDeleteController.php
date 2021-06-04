<?php


namespace App\Controller\Api\v1\Airline;


use App\Controller\Api\AbstractController;
use App\DTO\NotFoundDTO;
use App\DTO\SuccessDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AirlineDeleteController extends AbstractController
{
    /**
     * Удалить авиакомпанию
     *
     * @OA\Delete (
     *      path="/api/v1/airlines/{id}",
     *      tags={"Авиакомпании"},
     *      @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          example="Bearer c16e40fa31e1c99849c0",
     *          @OA\Schema(type="string"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Успех",
     *          @OA\JsonContent(ref="#/components/schemas/SuccessDTO"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Авиакомпания не найдена",
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
        $id = (int) $request->getAttribute('id');
        $result = $this->airlineService->delete($id);

        $data = $result ? new SuccessDTO() : new NotFoundDTO();

        return $this->jsonResponse($response, $data);
    }

}
