<?php

declare(strict_types=1);

namespace App\Controller\Api\v1\Requests;

use App\Framework\Controller\AbstractController;
use App\Framework\Http\JsonResponse;
use App\Framework\Http\RequestInterface;
use App\Model\Request\Entity\Id;
use App\Model\Request\UseCase\Add\AddRequestCommand;
use App\Model\Request\UseCase\Add\AddRequestHandler;
use App\Model\Request\UseCase\Add\AddRequestForm;
use App\ReadModel\Request\RequestFetcher;
use App\Service\Hydrator\HydratorInterface;
use Exception;
use InvalidArgumentException;

/**
 * @OA\Info(title="Requests Api", version="1.0.0")
 */
class RequestsController extends AbstractController
{
    private HydratorInterface $hydrator;

    public function __construct(HydratorInterface $hydrator)
    {
        $this->hydrator = $hydrator;
    }

    /**
     * @OA\Post(
     *      path="/api/v1/requests/add",
     *      operationId="add",
     *      summary="Регистрирует запрос пользователя",
     *      @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(
     *                  required={"name"},
     *                  @OA\Property(
     *                      property="name",
     *                      type="string",
     *                      description="Название запроса"
     *                  ),
     *                 example={"name": "Тестовый запрос"}
     *              )
     *          ),
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="id", type="string", example="b6cdb570-af40-4130-8ee2-d7318eb2fc91")
     *          )
     *      ),
     *      @OA\Response(
     *          response="400",
     *          description="Ошибка валидации",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="name обязательно для заполнения")
     *          )
     *      ),
     *      @OA\Response(
     *          response="500",
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string")
     *          )
     *      )
     * )
     */
    public function add(RequestInterface $request, AddRequestHandler $addRequestHandler): JsonResponse
    {
        try {
            $form = new AddRequestForm();
            $form->handleRequest($request);

            if (!$form->isValid()) {
                throw new InvalidArgumentException($form->getErrorMessage());
            }

            $requestId = Id::next();

            $formData = array_merge($form->getValidData(), ['id' => $requestId->getValue()]);

            /* @var AddRequestCommand $command */
            $command = $this->hydrator->hydrate(AddRequestCommand::class, $formData);

            $addRequestHandler->handle($command);

            return $this->createSuccessJsonResponse(['id' => $requestId->getValue()]);
        } catch (Exception $e) {
            return $this->createFailJsonResponse(['message' => $e->getMessage()]);
        }
    }

    /**
     * @OA\Get(
     *      path="/api/v1/requests/{id}/status",
     *      operationId="getStatus",
     *      summary="Возвращает статус запроса",
     *     @OA\Parameter(
     *          description="Номер запроса",
     *          in="path",
     *          name="id",
     *          required=true,
     *         @OA\Schema(type="string"),
     *         @OA\Examples(example="uuid", value="b6cdb570-af40-4130-8ee2-d7318eb2fc91", summary="uuid")
     *      ),
     *      @OA\Response(
     *          response="200",
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="status", type="integer", example="1"),
     *              @OA\Property(property="status_name", type="string", example="Обработан")
     *          )
     *      ),
     *      @OA\Response(
     *          response="404",
     *          description="Запрос не найден",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  type="string",
     *                  example="Запрос b6cdb570-af40-4130-8ee2-d7318eb2fc91 не найден"
     *              )
     *          )
     *      ),
     *      @OA\Response(
     *          response="500",
     *          description="Internal Server Error",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="")
     *          )
     *      )
     * )
     */
    public function getStatus(RequestFetcher $requestFetcher, string $id): JsonResponse
    {
        try {
            if (!$status = $requestFetcher->getStatus(new Id ($id))) {
                return new JsonResponse(404, ['message' => 'Запрос ' . $id . ' не найден']);
            }

            return $this->createSuccessJsonResponse($status);
        } catch (Exception $e) {
            return $this->createFailJsonResponse(['message' => $e->getMessage()]);
        }
    }
}