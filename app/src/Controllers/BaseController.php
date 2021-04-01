<?php


namespace App\Controllers;


use App\Core\RedirectResponse;
use App\Core\Request;
use App\Core\Response;
use App\Core\View;

class BaseController
{
    protected string $content;
    protected string $title = 'Test project';

    protected function response(string $content, int $code = 200, array $headers = []) : string
    {
        return new Response($content, $code, $headers);
    }

    protected function redirect(string $route, int $code = 301, array $headers = []): string
    {
        $url = $_ENV['APP_URL'] . '/' . $route;

        return new RedirectResponse($url, $code, $headers);
    }

    protected function viewResponse(int $code = 200, array $headers = []) : string
    {
        return $this->response($this->renderLayout(), $code, $headers);
    }

    protected function renderLayout() : string
    {
        return $this->renderView('layout', [
            'content' => $this->content,
            'title' => $this->title,
            'currentUrl' => Request::getInstance()->getRequestUri(),
        ]);
    }

    protected function renderView(string $viewPath, array $arguments = []) : string
    {
        return (new View($viewPath, $arguments))->render();
    }
}