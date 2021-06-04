<?php


namespace App\Controller\Api\v1;


use App\Controller\Api\AbstractController;
use App\DTO\EntityDTO;
use App\DTO\EntitiesDTO;
use App\DTO\BadRequestDTO;
use App\DTO\NotFoundDTO;
use App\DTO\SuccessDTO;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use OpenApi\Annotations as OA;

/**
 * Class AirlineController
 *
 * @OA\Route("/api/v1/airlines")
 */
class AirlineController extends AbstractController
{
    /**
     * @OA\Get(
     *   path="/api/v1/airlines",
     *   summary="list airlines",
     *   tags={"Авиакомпании"},
     *   security={"api_key"},
     *   @OA\Parameter(
     *         name="Authorization",
     *         in="header",
     *         required=true,
     *         example="Bearer c16e40fa31e1c99849c0",
     *         @OA\Schema(type="string"),
     *     ),
     *   @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Лимит записей",
     *         example="10",
     *         @OA\Schema(type="integer")
     *     ),
     *   @OA\Parameter(
     *         name="offset",
     *         in="query",
     *         description="Смещение от начала записей",
     *         example="2",
     *         @OA\Schema(type="integer")
     *     ),
     *   @OA\Response(
     *     response=200,
     *     description="Список авиакомпаний",
     *     @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/Airline")
     *      ),
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Авиакомпании не найдены",
     *     @OA\JsonContent(ref="#/components/schemas/NotFoundDTO")
     *   ),
     *   @OA\Response(
     *      response=403,
     *      description="Доступ запрещен",
     *      @OA\JsonContent(ref="#/components/schemas/ForbiddenDTO"),
     *     )
     * )
     */
    public function index(Request $request, Response $response): Response
    {
        list ($limit, $offset) = array_values($request->getQueryParams());

        $airlines = $this->airlineService->getAll($limit, $offset);
        $data = $airlines ? new EntitiesDTO($airlines): new NotFoundDTO();

        return $this->jsonResponse($response, $data);
    }

    public function create(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $result = $this->airlineService->create($data);

        $data =  $result
            ? new EntityDTO($result, StatusCodeInterface::STATUS_CREATED)
            : new BadRequestDTO();

        return $this->jsonResponse($response, $data);
    }

    public function read(Request $request, Response $response): Response
    {
        $id = (int) $request->getAttribute('id');
        $result = $this->airlineService->read($id);

        $data = $result ? new EntityDTO($result) : new NotFoundDTO();

        return $this->jsonResponse($response, $data);
    }

    public function update(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $result = $this->airlineService->update($data);

        $data =  $result ? new SuccessDTO() : new BadRequestDTO();

        return $this->jsonResponse($response, $data);
    }

    public function delete(Request $request, Response $response): Response
    {
        $id = (int) $request->getAttribute('id');
        $result = $this->airlineService->delete($id);

        $data = $result ? new SuccessDTO() : new BadRequestDTO();

        return $this->jsonResponse($response, $data);
    }
}
