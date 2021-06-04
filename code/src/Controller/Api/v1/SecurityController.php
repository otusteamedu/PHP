<?php


namespace App\Controller\Api\v1;


use App\Controller\Api\AbstractController;
use App\DTO\BadRequestDTO;
use App\DTO\TokenDTO;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;


class SecurityController extends AbstractController
{
    /**
     * Вход, получить токен
     *
     * @OA\Post(
     *      path="/api/v1/login",
     *      tags={"Security"},
     *      @OA\RequestBody(
     *          description="Данные пользователя",
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  @OA\Property(property="email", type="string", description="email", example="user@example.com"),
     *                  @OA\Property(property="password", type="string", description="пароль", example="password123"),
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Токен",
     *          @OA\JsonContent(ref="#/components/schemas/TokenDTO"),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Неверные данные",
     *          @OA\JsonContent(ref="#/components/schemas/BadRequestDTO"),
     *      ),
     *  )
     */
    public function login(Request $request, Response $response): Response
    {
        try {
            list ($email, $password) = array_values($request->getParsedBody());

            $token = $this->security->login($email, $password);

            $data = $token ? new TokenDTO($token) : new BadRequestDTO();
        } catch (\Exception $e) {
            $data = new BadRequestDTO();
        }

        return $this->jsonResponse($response, $data);
    }
}
