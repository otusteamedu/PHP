<?php


namespace App\Controller\Api\v1;


use App\DTO\NotFoundDTO;
use App\DTO\UsersDTO;
use App\Entity\User;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use OpenApi\Annotations as OA;
use App\Controller\Api\AbstractController;

/**
 * @author Alexandr Timofeev
 *
 *
 * @Annotations\Route("/api/v1/users")
 */
final class UserController extends AbstractController
{
    /**
     * @OA\Get(
     *   path="/api/v1/users",
     *   summary="list users",
     *   tags={"Пользователи"},
     *   @OA\Response(
     *     response=200,
     *     description="Список всех пользователей",
     *     @OA\JsonContent(
     *          type="array",
     *          @OA\Items(ref="#/components/schemas/User")
     *      ),
     *   ),
     *   @OA\Response(
     *     response=404,
     *     description="Пользователи не найдены",
     *     @OA\JsonContent(ref="#/components/schemas/NotFoundDTO"),
     *
     *   )
     * )
     */
    public function usersAction(Request $request, Response $response): Response
    {
        /** @var User[] $users */
        $users = $this->entityManager
            ->getRepository(User::class)
            ->findAll();

        $data = $users ? new UsersDTO($users) : new NotFoundDTO();

        return $this->jsonResponse($response, $data);
    }

}
