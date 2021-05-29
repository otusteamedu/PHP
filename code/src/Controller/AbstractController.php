<?php

namespace App\Controller;


use App\Entity\User;
use App\Service\BankOperation\BankOperationInterface;
use App\Service\Security\SecurityInterface;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

abstract class AbstractController
{
    protected PhpRenderer $view;
    protected ?User $user;
    protected SecurityInterface $security;
    protected ContainerInterface $container;
    protected BankOperationInterface $bankOperation;

    /**
     * AbstractController constructor.
     * @param \Psr\Container\ContainerInterface $container
     * @param \App\Service\Security\SecurityInterface $security
     * @param \App\Service\BankOperation\BankOperationInterface $bankOperation
     */
    public function __construct(
        ContainerInterface $container,
        SecurityInterface $security,
        BankOperationInterface $bankOperation
    )
    {
        $this->container = $container;
        $this->security = $security;
        $this->bankOperation = $bankOperation;

        $this->user = $security->getIdentity();

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

    /**
     * @param array $scripts
     */
    protected function addScripts(array $scripts): void
    {
        $this->view->addAttribute(
            'scripts',
            array_merge($this->view->getAttribute('scripts'), $scripts)
        );
    }

    /**
     * @param array $styles
     */
    protected function addStyles(array $styles):void
    {
        $this->view->addAttribute(
            'styles',
            array_merge($this->view->getAttribute('styles'), $styles)
        );
    }

    /**
     * @param \Psr\Http\Message\ResponseInterface $response
     * @param string $template
     * @param array $params
     * @return \Psr\Http\Message\ResponseInterface
     * @throws \Throwable
     */
    protected function render(Response $response, string $template, array $params = []): Response
    {
        return $this->view->render($response, $template, $params);
    }
}
