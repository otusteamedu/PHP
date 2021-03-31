<?php

namespace App\Controller;


use App\Services\Orm\ModelManager;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

abstract class AbstractController
{

    /**
     * @var PhpRenderer $view
     */
    protected PhpRenderer $view;

    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;
    protected ModelManager $modelManager;

    /**
     * BaseController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->modelManager = $container->get(ModelManager::class);

        $this->view = new PhpRenderer(
            __DIR__ . '/../templates',
            [
                'title' => $container->get('name'),
                'style' => '/css/bootstrap.min.css',
                'scripts' => [],
            ],
            'layout.php'
        );

    }

    protected function render(Response $response, string $template, array $params = []): Response
    {
        return $this->view->render($response, $template, $params);
    }
}
