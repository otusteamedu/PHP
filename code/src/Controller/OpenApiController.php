<?php


namespace App\Controller;


use OpenApi\Generator;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Views\PhpRenderer;
use OpenApi\Annotations as OA;


class OpenApiController
{
    private PhpRenderer $renderer;

    /**
     * OpenApiController constructor.
     * @param \Psr\Container\ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->renderer = $container->get(PhpRenderer::class);
    }


    /**
     * Документация по API
     *
     * @OA\Info(
     *     title="My API",
     *     version="1.0",
     *     description="Сервис авиарейсов. Создание, редактирование расписания рейсов. Создание авиакомпаний",
     *     )
     *
     * @OA\Server(
     *     description="Dev server",
     *     url="http://localhost",
     * ),
     *
     * @param \Psr\Http\Message\ServerRequestInterface $request
     * @param \Psr\Http\Message\ResponseInterface $response
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Throwable
     */
    public function __invoke(Request $request, Response $response): Response
    {
        $openapi = Generator::scan([
            __DIR__,
            __DIR__ . '/../Entity',
        ]);

        return $this->renderer->render($response, 'openapi/index.php', [
            'data' => $openapi->toJson(),
        ]);
    }


}
