<?php


namespace App\Controller\Api\v1;


use App\Controller\Api\AbstractController;
use App\DTO\AirlineDTO;
use App\DTO\AirlinesDTO;
use App\DTO\BadRequestDTO;
use App\DTO\DeletedDTO;
use App\DTO\NotFoundDTO;
use App\DTO\UpdatedDTO;
use Fig\Http\Message\StatusCodeInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AirlineController extends AbstractController
{
    public function index(Request $request, Response $response): Response
    {
        list ($limit, $offset) = array_values($request->getQueryParams());

        $airlines = $this->airlineService->getAll($limit, $offset);
        $data = $airlines ? new AirlinesDTO($airlines): new NotFoundDTO();

        return $this->jsonResponse($response, $data);
    }

    public function create(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $result = $this->airlineService->create($data);

        $data =  $result
            ? new AirlineDTO($result, StatusCodeInterface::STATUS_CREATED)
            : new BadRequestDTO();

        return $this->jsonResponse($response, $data);
    }

    public function read(Request $request, Response $response): Response
    {
        $id = (int) $request->getAttribute('id');
        $result = $this->airlineService->read($id);

        $data = $result ? new AirlineDTO($result) : new NotFoundDTO();

        return $this->jsonResponse($response, $data);
    }

    public function update(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $result = $this->airlineService->update($data);

        $data =  $result ? new UpdatedDTO() : new BadRequestDTO();

        return $this->jsonResponse($response, $data);
    }

    public function delete(Request $request, Response $response): Response
    {
        $id = (int) $request->getAttribute('id');
        $result = $this->airlineService->delete($id);

        $data = $result ? new DeletedDTO() : new BadRequestDTO();

        return $this->jsonResponse($response, $data);
    }
}
