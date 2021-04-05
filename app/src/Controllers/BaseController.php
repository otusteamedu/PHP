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

    protected function redirect(string $route, int $code = 302, array $headers = []): string
    {
        $url = env('APP_URL') . '/' . $route;

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
        $viewPath = str_replace('.', '/', $viewPath);
        $viewPath = '/' . trim(str_replace('.', '/', $viewPath), '/');

        return (new View($viewPath, $arguments))->render();
    }

    protected function getRequest() : Request
    {
        return Request::getInstance();
    }
}