<?php


namespace App\Controller\Api\v1\City;


use App\Controller\Api\AbstractController;
use App\DTO\EntityDTO;
use App\DTO\NotFoundDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class CityReadController extends AbstractController
{
    /**
     * Найти город
     *
     * @OA\Get(
     *      path="/api/v1/cities/{id}",
     *      tags={"Города"},
     *      @OA\Parameter(
     *          name="Authorization",
     *          in="header",
     *          required=true,
     *          example="Bearer c16e40fa31e1c99849c0",
     *          @OA\Schema(type="string"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Город",
     *          @OA\JsonContent(ref="#/components/schemas/City"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Город не найден",
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
        $result = $this->cityService->read($id);

        $data = $result ? new EntityDTO($result) : new NotFoundDTO();

        return $this->jsonResponse($response, $data);
    }

}
