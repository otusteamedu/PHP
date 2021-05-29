<?php

namespace App\Controller;


use App\Entity\User;
use App\Service\Message\MessageServiceInterface;
use App\Service\Security\SecurityInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

abstract class AbstractController
{

    protected PhpRenderer $view;
    protected ?User $user;
    protected SecurityInterface $security;
    protected MessageServiceInterface $messageService;

    protected ?string $error = null;


    /**
     * @var ContainerInterface
     */
    protected ContainerInterface $container;

    /**
     * BaseController constructor.
     * @param ContainerInterface $container
     */
    public function __construct(
        ContainerInterface $container,
        SecurityInterface $security,
        MessageServiceInterface $messageService
    )
    {
        $this->container = $container;
        $this->security = $security;
        $this->user = $security->getIdentity();
        $this->messageService = $messageService;

        $appName = $container->get('app_name');

        $this->view = $container->get(PhpRenderer::class);

        $this->view->setAttributes([
            'title' => $appName,
            'app_name' => $appName,
            'user' => $this->user,
            'styles' => ['bootstrap.min.css', 'style.css'],
            'scripts' => [],
        ]);
        $this->view->setLayout('layout.php');

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

    /**
     * @throws \Throwable
     */
    protected function render(Response $response, string $template, array $params = []): Response
    {
        return $this->view->render($response, $template, $params);
    }
}
