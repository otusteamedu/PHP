<?php

namespace App\Controller;


use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

abstract class AbstractController
{

    /**
     * @var PhpRenderer $view
     */
    protected PhpRenderer $view;

    protected ?string $error = null;


    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * BaseController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;

        $appName = $container->get('app_name');

        $this->view = new PhpRenderer(
            dirname(__DIR__, 1) . '/../templates',
            [
                'title' => $appName,
                'app_name' => $appName,
                'styles' => ['bootstrap.min.css'],
                'scripts' => ['/js/common.js'],
            ],
            'layout.php'
        );

    }

    protected function addScripts(array $scripts)
    {
        $this->view->addAttribute(
            'scripts',
            array_merge($this->view->getAttribute('scripts'), $scripts)
        );
    }

    protected function addStyles(array $styles)
    {
        $this->view->addAttribute(
            'styles',
            array_merge($this->view->getAttribute('styles'), $styles)
        );
    }

    protected function render(Response $response, string $template, array $params = []): Response
    {
        return $this->view->render($response, $template, $params);
    }
}
